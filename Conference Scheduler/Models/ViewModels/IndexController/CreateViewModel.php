<?php

namespace Models\ViewModels\IndexController;

class CreateViewModel
{
    private $someShit;

    public function __construct($someShit)
    {
        $this->someShit = $someShit;
    }

    /**
     * @return mixed
     */
    public function getSomeShit()
    {
        return $this->someShit;
    }
}