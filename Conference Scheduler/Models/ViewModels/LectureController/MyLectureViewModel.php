<?php

namespace Models\ViewModels\LectureController;

class MyLectureViewModel
{
    private $id;
    private $name;
    private $description;
    private $start;
    private $end;
    private $speaker;
    private $conference;
    private $hall;

    public function __construct($id, $name, $description, $start, $end, $speaker, $conference, $hall)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->start = $start;
        $this->end = $end;
        $this->speaker = $speaker;
        $this->conference = $conference;
        $this->hall = $hall;
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
}