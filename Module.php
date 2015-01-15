<?php
namespace OnyxCode;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use OnyxCode\Model\OnyxSkuTable;
use OnyxCode\Model\OnyxSku;
use OnyxCode\Model\OnyxCodeTable;
use OnyxCode\Model\OnyxCode;

class Module
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'OnyxSkuTable' =>  function($sm) {
                    $tableGateway = $sm->get('OnyxSkuTableGateway');
                    $table = new OnyxSkuTable($tableGateway);
                    return $table;
                },
                'OnyxSkuTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new OnyxSku());
                    return new TableGateway('onyx_sku', $dbAdapter, null, $resultSetPrototype);
                },
                'OnyxCodeTable' =>  function($sm) {
                    $tableGateway = $sm->get('OnyxCodeTableGateway');
                    $table = new OnyxCodeTable($tableGateway);
                    return $table;
                },
                'OnyxCodeTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new OnyxCode());
                    return new TableGateway('onyx_code', $dbAdapter, null, $resultSetPrototype);
                },      
            ),
            
        );
    }

}
