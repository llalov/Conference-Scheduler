<?php

namespace Models\ViewModels\LectureController;

class OpenViewModel
{
    private $lectures;
    private $usersLectures;

    public function __construct($lectures, $usersLectures)
    {
        $this->lectures = $lectures;
        $this->usersLectures = $usersLectures;
    }

    public function getLectures() {
        return $this->lectures;
    }

    public function getUsersLectures() {
        return $this->usersLectures;
    }
}