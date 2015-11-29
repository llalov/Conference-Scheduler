<?php

namespace Models\ViewModels\LectureController;

class IndexViewModel
{
    private $lectures;

    public function __construct($lectures)
    {
        $this->lectures = $lectures;
    }

    public function getLectures() {
        return $this->lectures;
    }
}