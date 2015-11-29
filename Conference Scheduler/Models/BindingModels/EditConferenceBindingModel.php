<?php

namespace Models\BindingModels;

class EditConferenceBindingModel
{
    private $name;
    private $description;
    private $start;
    private $end;

    function __construct(array $params)
    {
        $this->setName($params['name']);
        $this->setDescription($params['description']);
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