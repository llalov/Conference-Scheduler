<?php

namespace Models\ViewModels\ConferenceController;

class AdminViewModel
{
    private $id;
    private $username;

    public function __construct($id, $username)
    {
        $this->id = $id;
        $this->username = $username;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }
}