<?php

/**
 * Description of LoginController
 *
 * @author broklyn
 */

namespace User\Controller;

class LoginController extends \Jazz\Controller\Controller
{
    public function indexAction()
    {
        return new \Symfony\Component\HttpFoundation\Response('ini Login Controller');
    }
}