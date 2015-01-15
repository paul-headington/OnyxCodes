<?php


namespace OnyxPrize\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class PrizeController extends AbstractActionController
{
    protected $eventIdentifier = 'Onyx\Service\EventManger';

    public function onDispatch( \Zend\Mvc\MvcEvent $e ){
        return parent::onDispatch($e);
    }

    public function __construct(){

    }

    public function indexAction()
    {

        $return = array();
        return new ViewModel($return);
    }



}
