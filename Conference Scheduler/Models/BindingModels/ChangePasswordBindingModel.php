<?php

namespace Models\BindingModels;

class ChangePasswordBindingModel
{
    private $oldPassword;
    private $newPassword;
    private $confirm;

    public function __construct($model)
    {
        $this->setOldPassword($model['oldPassword']);
        $this->setNewPassword($model['newPassword']);
        $this->setConfirm($model['confirm']);
    }

    /**
     * @return mixed
     */
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * @param mixed $oldPassword
     */
    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = hash('ripemd160', $oldPassword);
    }

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = hash('ripemd160', $newPassword);
    }

    /**
     * @return mixed
     */
    public function getConfirm()
    {
        return $this->confirm;
    }

    /**
     * @param mixed $confirm
     */
    public function setConfirm($confirm)
    {
        $this->confirm = hash('ripemd160', $confirm);
    }
}