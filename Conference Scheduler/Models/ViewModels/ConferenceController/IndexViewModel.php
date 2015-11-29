<?php

namespace Models\ViewModels\ConferenceController;

class IndexViewModel
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