<?php

namespace Models\ViewModels\ConferenceController;

class EditViewModel
{
    private $name;
    private $description;
    private $owner;
    private $venue;
    private $start;
    private $end;

    public function __construct($name, $description, $owner, $venue, $start, $end)
    {
        $this->name = $name;
        $this->description = $description;
        $this->owner = $owner;
        $this->venue = $venue;
        $this->start = $start;
        $this->end = $end;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getOwner() {
        return $this->owner;
    }

    public function getVenue() {
        return $this->venue;
    }

    public function getStart() {
        return $this->start;
    }

    public function getEnd() {
        return $this->end;
    }
}