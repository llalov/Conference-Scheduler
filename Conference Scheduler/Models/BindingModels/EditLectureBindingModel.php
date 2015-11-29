<?php

namespace Models\BindingModels;

class EditLectureBindingModel
{
    private $name;
    private $description;
    private $speaker;
    private $start;
    private $end;
    private $hall;
    private $conference;

    function __construct(array $params)
    {
        $this->setName($params['name']);
        $this->setDescription($params['description']);
        $this->setSpeaker($params['speaker']);
        $this->setStart($params['start']);
        $this->setEnd($params['end']);
        $this->setConf($params['conference']);
        $this->setHall($params['hall']);
    }

    /**
 * @return string
 */
    public function getConf()
    {
        return $this->conference;
    }

    /**
     * @param string $conf
     */
    public function setConf($conf) {
        $this->conference = $conf;
    }

    /**
     * @return string
     */
    public function getHall()
    {
        return $this->hall;
    }

    /**
     * @param string $hall
     */
    public function setHall($hall) {
        $this->hall = $hall;
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