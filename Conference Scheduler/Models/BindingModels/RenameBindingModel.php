<?php

namespace Models\BindingModels;

class RenameBindingModel
{
    private $oldName;
    private $newName;

    public function __construct(array $params)
    {
        $this->setOldName($params['oldName']);
        $this->setNewName($params['newName']);
    }

    /**
     * @return mixed
     */
    public function getOldName()
    {
        return $this->oldName;
    }

    /**
     * @param mixed $oldName
     */
    public function setOldName($oldName)
    {
        $this->oldName = $oldName;
    }

    /**
     * @return mixed
     */
    public function getNewName()
    {
        return $this->newName;
    }

    /**
     * @param mixed $newName
     */
    public function setNewName($newName)
    {
        $this->newName = $newName;
    }
}