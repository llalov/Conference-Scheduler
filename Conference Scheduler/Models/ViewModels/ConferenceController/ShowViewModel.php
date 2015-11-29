<?php

namespace Models\ViewModels\ConferenceController;

class ShowViewModel
{
    private $lectures;
    private $start;
    private $end;
    private $conference;

    public function __construct($lectures, $start, $end, $conference)
    {
        $this->conference = $conference;
        $this->start = $start;
        $this->end = $end;
        $this->conference = $conference;
    }

    public function getConference()
    {
        return $this->conference;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function getLectures()
    {
        return $this->lectures;
    }
}