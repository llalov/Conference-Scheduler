<?php

namespace Models\ViewModels\ConferenceController;

class ManageAdminsViewModel
{
    private $confId;
    private $admins;

    public function __construct(array $admins, $confId)
    {
        $this->admins = $admins;
        $this->confId = $confId;
    }

    public function getAdmins(){
        return $this->admins;
    }

    public function getConfId() {
        return $this->confId;
    }
}