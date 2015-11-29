<?php

namespace Models\ViewModels\ConferenceController;

class OpenConferenceViewModel
{
    private $id;
    private $name;
    private $description;
    private $owner;
    private $venue;
    private $start;
    private $end;

    function __construct($id, $name, $description, $owner, $venue, $start, $end)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->owner = $owner;
        $this->venue = $venue;
        $this->start = $start;
        $this->end = $end;
    }

    public function getId() {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
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