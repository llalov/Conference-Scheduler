<?php

namespace Models\ViewModels\ConferenceController;

class OpenViewModel
{
    private $conferences;

    public function __construct(array $conferences)
    {
        $this->conferences = $conferences;
    }

    public function getConferences() {
        return $this->conferences;
    }
}