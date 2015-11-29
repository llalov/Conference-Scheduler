<?php

namespace Models\ViewModels\LectureController;

class EditViewModel
{
    private $name;
    private $description;
    private $start;
    private $end;
    private $speaker;
    private $hall;
    private $conference;

   public function __construct($name, $description, $start, $end, $speaker, $hall, $conference)
   {
       $this->name = $name;
       $this->description = $description;
       $this->start = $start;
       $this->end = $end;
       $this->speaker = $speaker;
       $this->hall = $hall;
       $this->conference = $conference;
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

    public function getHall() {
        return $this->hall;
    }

    public function getConference() {
        return $this->conference;
    }
}