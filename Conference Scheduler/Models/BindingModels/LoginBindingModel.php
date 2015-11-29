<?php

namespace Models\BindingModels;

use Mvc\HttpContext\HttpContext;

class LoginBindingModel
{
    private $username;
    private $password;

    function __construct(array $params)
    {
        $context = HttpContext::getInstance();
        $this->setPassword($params['password']);
        $this->setUsername($params['username']);
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

    /**
     * Work around to avoid double crypting passwords when login in after registration.
     */
    public function afterRegisterPasswordPass($password){
        $this->password = $password;
    }
}