<?php

namespace Models\ViewModels\LectureController;

class OpenLectureViewModel
{
    private $id;
    private $name;
    private $description;
    private $start;
    private $end;
    private $speaker;
    private $conference;
    private $hall;
    private $usersRegistered;
    private $hallCount;

    public function __construct($id, $name, $description, $start, $end, $speaker, $conference, $hall, $usersRegistered, $hallCount)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->start = $start;
        $this->end = $end;
        $this->speaker = $speaker;
        $this->conference = $conference;
        $this->hall = $hall;
        $this->usersRegistered = $usersRegistered;
        $this->hallCount = $hallCount;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getStart() {
        return $this->start;
    }

    public function getEnd() {
        return $this->end;
    }

    public function getSpeaker() {
        return $this->speaker;
    }

    public function getConference() {
        return $this->conference;
    }

    public function getHall() {
        return $this->hall;
    }

    public function getUsersRegistered() {
        return $this->usersRegistered;
    }

    public function getHallCount() {
        return $this->hallCount;
    }
}