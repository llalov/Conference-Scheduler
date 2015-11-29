<?php

namespace Routers;

use Mvc\Routers\IRouter;

include '../../Mvc-Framework/Routers/IRouter.php';

class DummyRouter implements IRouter
{
    /**
     * @return 'package/controller/method/param[0]/param[1]'
     */
    public function getURI()
    {
        return 'admin/index2/new';
    }

    public function getPost()
    {
        return array('Dummy' => 'Router');
    }

    public function getRequestMethod()
    {
        return 'get';
    }
}