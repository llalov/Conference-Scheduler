<?php

namespace Models\ViewModels\ConferenceController;

class MaxLecturesViewModel
{
    private $lectures;
    private $userLectures;

    public function __construct(array $lectures, array $userLectures)
    {
        $this->lectures = $lectures;
        $this->userLectures = $userLectures;
    }

    public function getLectures() {
        return $this->lectures;
    }

    public function getUserLectures() {
        return $this->userLectures;
    }
}