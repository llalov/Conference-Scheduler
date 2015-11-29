<?php

namespace Models\ViewModels\ConferenceController;

class LecturesViewModel
{
    private $lectures;

    public function __construct(array $lectures)
    {
        $this->lectures = $lectures;
    }

    public function getLectures() {
        return $this->lectures;
    }
}