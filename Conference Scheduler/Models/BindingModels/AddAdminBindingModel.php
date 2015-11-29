<?php

namespace Models\BindingModels;

class AddAdminBindingModel
{
    private $name;

    public function __construct(array $params)
    {
        $this->setName($params['name']);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}