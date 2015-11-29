<?php

namespace Models\ViewModels\UserController;

class AllUsersViewModel
{
    private $users;
    private $start;
    private $end;

    function __construct(array $users, $start, $end)
    {
        $this->users = $users;
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }
}