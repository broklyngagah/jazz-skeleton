<?php

/**
 * Description of LogoutController
 *
 * @author broklyn
 */

namespace User\Controller;

class LogoutController extends \Jazz\Controller\Controller
{
    
    public function indexAction()
    {
        return new Symfony\Component\HttpFoundation\Response('Logout Controller');
    }
    
}




