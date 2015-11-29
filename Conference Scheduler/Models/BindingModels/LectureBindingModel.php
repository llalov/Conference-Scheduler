<?php

namespace Models\BindingModels;

use Mvc\HttpContext\HttpContext;

class LectureBindingModel
{
    private $name;
    private $description;
    private $start;
    private $end;
    private $speaker;
    private $hall;

    public function __construct(array $params)
    {
        $context = HttpContext::getInstance();
        $this->setName($params['name']);
        $this->setDescription($params['description']);
        $this->setSpeaker($params['speaker']);
        $this->setHall($params['hall']);
        $this->setEnd($params['end']);
        $this->setStart($params['start']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @param string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     */
    private function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param string
     */
    public function getStart() {
        return $this->start;
    }

    /**
     * @param string $start
     */
    private function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @param string
     */
    public function getEnd() {
        return $this->end;
    }

    /**
     * @param string $end
     */
    private function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @param string
     */
    public function getSpeaker() {
        return $this->speaker;
    }

    /**
     * @param string $speaker
     */
    private function setSpeaker($speaker)
    {
        $this->speaker = $speaker;
    }

    /**
     * @param string
     */
    public function getHall() {
        return $this->hall;
    }

    /**
     * @param string $hall
     */
    private function setHall($hall)
    {
        $this->hall = $hall;
    }
}