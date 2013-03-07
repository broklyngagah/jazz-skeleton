<?php

namespace Application\Management\Controller;

use Jazz\Controller\Controller;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;
use Application\Management\Repository\CurrencyRepository;

class CurrencyController extends Controller
{
    public function indexAction()
    {
        $curRepo = CurrencyRepository::getCurrencyList($this->app);
        return $this->render('management/currency/index.html.twig', array(
            'currency' => $curRepo,
        ));
    }

    public function createAction()
    {
        return $this->render('management/currency/create.html.twig');
    }

    public function editAction($id=0)
    {
        if('POST' === $this->get('request')->getMethod()) {

        }

        $currency = CurrencyRepository::getRow($this->app, $id);
        return $this->render('management/currency/edit.html.twig', array(
            'currency' => $currency,
        ));
    }


}