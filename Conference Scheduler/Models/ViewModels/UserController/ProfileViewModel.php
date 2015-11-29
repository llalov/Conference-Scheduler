<?php

namespace Models\ViewModels\UserController;

class ProfileViewModel
{
    private $username;
    private $email;
    private $isAdmin;

    function __construct($username, $email)
    {
        $this->username = $username;
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getIsAdmin() {
        return $this->isAdmin;
    }
}