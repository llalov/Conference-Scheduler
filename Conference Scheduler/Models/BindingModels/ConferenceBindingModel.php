<?php

namespace Models\BindingModels;

use Mvc\HttpContext\HttpContext;

class ConferenceBindingModel
{
    private $name;
    private $description;
    private $venue;
    private $start;
    private $end;

    function __construct(array $params)
    {
        $context = HttpContext::getInstance();
        $this->setName($params['name']);
        $this->setDescription($params['description']);
        $this->setVenue($params['venue']);
        $this->setStart($params['start']);
        $this->setEnd($params['end']);
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
    public function getVenue() {
        return $this->venue;
    }

    /**
     * @param string $venue
     */
    private function setVenue($venue)
    {
        $this->venue = $venue;
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
}