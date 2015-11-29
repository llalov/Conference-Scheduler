<?php

namespace Models\BindingModels;


class RegisterBindingModel
{
    private $username;
    private $password;
    private $confirm;
    private $email;

    function __construct(array $params)
    {
        $this->setPassword($params['password']);
        $this->setUsername($params['username']);
        $this->setConfirm($params['confirm']);
        $this->setEmail($params['email']);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    private function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    private function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    private function setPassword($password)
    {
        $this->password = hash('ripemd160', $password);
    }


    public function getConfirm(){
        return $this->confirm;
    }

    private function setConfirm($password)
    {
        $this->confirm = hash('ripemd160', $password);
    }
}