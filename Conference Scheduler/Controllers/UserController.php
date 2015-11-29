<?php
declare(strict_types=1);

namespace Controllers;

use Mvc\BaseController;
use Mvc\Normalizer;
use Models\BindingModels\ChangePasswordBindingModel;
use Models\BindingModels\LoginBindingModel;
use Models\BindingModels\RegisterBindingModel;
use Models\ViewModels\UserController\AllUsersViewModel;
use Models\ViewModels\UserController\ProfileViewModel;
use Models\ViewModels\UserController\User;

class UserController extends BaseController
{
    /**
     * @Get
     * @Route("users/delete/{username:string}")
     */
    public function delete() {
        $_SESSION['userToDelete'] = $this->input->get(2);
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'deleteUser');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.deleteUser');
    }

    /**
     * @Route("users/deleteUser")
     */
    public function deleteUser() {
        $this->db->prepare("DELETE
                            FROM users
                            WHERE username = ?",
            array($_SESSION['userToDelete']));
        try {
            $response = $this->db->execute()->fetchAllAssoc();
            if (!$response) {
                throw new \Exception('No user matching provided username exist!', 400);
            }
        }
        catch(\Exception $e) {
            $this->redirect('/users/all/0/10');
        }
    }

    /**
     * @NotLogged
     * @param LoginBindingModel $model
     * @throws \Exception
     */
    public function login(LoginBindingModel $model)
    {
        $this->db->prepare("SELECT u.id as id, u.username as username, r.name as roleName
                            FROM users u
                            JOIN user_roles ur
                            ON u.id = ur.user_id
                            JOIN roles r
                            ON ur.role_id = r.id
                            WHERE username = ?",
            array($model->getUsername()));
        $response = $this->db->execute()->fetchRowAssoc();
        $id = $response['id'];
        $username = $response['username'];
        $role = $response['roleName'];
        $_SESSION['role'] = $role;

        $this->db->prepare("SELECT u.id as id, u.username as username, u.password as pass
                            FROM users u
                            WHERE username = ? AND password = ?",
            array($model->getUsername(), $model->getPassword()));
        $response = $this->db->execute()->fetchRowAssoc();
        if (!$response) {
            throw new \Exception('No user matching provided username or password!', 400);
        }
        $id = $response['id'];
        $username = $response['username'];
        $this->session->_login = $id;
        $this->session->_username = $model->getUsername();
        $this->session->escapedUsername = $username;
        $_SESSION['username'] = $response['username'];
        $_SESSION['role'] = $role;

        $this->redirect('/');
    }


    public function logout()
    {
        $this->session->destroySession();
        $this->redirect('/');
    }

    /**
     * @NotLogged
     * @param RegisterBindingModel $model
     * @throws \Exception
     */
    public function register(RegisterBindingModel $model)
    {
        if ($model->getPassword() !== $model->getConfirm()) {
            throw new \Exception("Password don't match Confirm Password!", 400);
        }

        if (!preg_match('/^[\w]{3,15}$/', $model->getUsername())) {
            throw new \Exception("Invalid username format!", 400);
        }

        // Check for already registered with the same name
        $this->db->prepare("SELECT id
                                FROM users
                                WHERE username = ?",
            array($model->getUsername()));
        $response = $this->db->execute()->fetchRowAssoc();
        $id = $response['id'];
        if ($id !== null) {
            $username = $model->getUsername();
            throw new \Exception("Username '$username' already taken!", 400);
        }

        // Check for already registered with the same email
        $this->db->prepare("SELECT id
                                FROM users
                                WHERE email = ?",
            array($model->getEmail()));
        $response = $this->db->execute()->fetchRowAssoc();
        $id = $response['id'];
        if ($id !== null) {
            $email = $model->getEmail();
            throw new \Exception("Email '$email' already taken!", 400);
        }

        $this->db->prepare("INSERT
                            INTO users
                            (username, password, email)
                            VALUES (?, ?, ?)",
            array(
                $model->getUsername(),
                $model->getPassword(),
                $model->getEmail()
            )
        )->execute();

        $loginBindingModel = new LoginBindingModel(array('username' => $model->getUsername(), 'password' => $model->getPassword()));
        // Work around to avoid double crypting passwords.
        $loginBindingModel->afterRegisterPasswordPass($model->getPassword());
        $this->login($loginBindingModel);
    }

    /**
     * @Get
     * @Route("user/{name:string}/profile")
     */
    public function profile() : ProfileViewModel
    {
        $username = $this->input->getForDb(1);
        $this->db->prepare("SELECT id, email
                                FROM users
                                WHERE username = ?",
            array($username));
        $response = $this->db->execute()->fetchRowAssoc();
        if ($response === false) {
            throw new \Exception("No user found with name '$username'", 404);
        }

        /*$isAdmin = $this->isAdmin();*/
        $email = $response['email'];

        $profileViewModel = new ProfileViewModel($username, $email);

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $profileViewModel);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.userProfile');

        return $profileViewModel;
    }

    /**
     * @Authorize
     * @Put
     * @Route("user/changePass")
     * @param ChangePasswordBindingModel $model
     * @throws \Exception
     */
    public function changePass(ChangePasswordBindingModel $model)
    {
        if ($model->getNewPassword() !== $model->getConfirm()) {
            throw new \Exception("Password don't match Confirm Password!", 400);
        }

        $username = $this->session->_username;
        $id = $this->session->_login;

        $this->db->prepare("SELECT id
                            FROM users
                            WHERE id = ? AND username = ? AND password = ?",
            array($id, $username, $model->getOldPassword()));
        $response = $this->db->execute()->fetchRowAssoc();
        if ($response) {
            $this->db->prepare("UPDATE users
                                SET password = ?
                                WHERE id = ? AND username = ? AND password = ?",
                array($model->getNewPassword(), $id, $username, $model->getOldPassword()));
            $this->db->execute();
            $this->redirect("/");
        } else {
            throw new \Exception("No user found matching those credentials!", 400);
        }
    }

    /**
     * @Route("users/all/{start:int}/{end:int}")
     * @Get
     */
    public function allUsers() : AllUsersViewModel
    {
        $skip = $this->input->get(2);
        $take = $this->input->get(3) - $skip;
        $this->db->prepare("SELECT
                            username, email
                            FROM users
                            ORDER BY username
                            LIMIT {$take}
                            OFFSET {$skip}");
        $response = $this->db->execute()->fetchAllAssoc();
        $users = array();
        foreach ($response as $u) {
            $users[] = new User(
                $u['username'],
                Normalizer::normalize($u['email'], 'noescape|bool')
            );
        }

        $allUsersViewModel = new AllUsersViewModel($users, $skip, $take + $skip);

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $allUsersViewModel);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.home');

        return $allUsersViewModel;
    }
}