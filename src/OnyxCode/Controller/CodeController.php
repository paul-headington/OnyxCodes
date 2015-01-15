<?php


namespace OnyxCode\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use OnyxCode\Model\OnyxCode;
use Zend\Console\Request as ConsoleRequest;


class CodeController extends AbstractActionController
{
    protected $eventIdentifier = 'Onyx\Service\EventManger';
    private $table = array();

    public function onDispatch( \Zend\Mvc\MvcEvent $e ){
        return parent::onDispatch($e);
    }

    public function __construct(){
        
    }

    public function indexAction()
    {
        $this->layout('layout/onyxsystem');
        
        $OnyxSkuTable = $this->getModelResource('OnyxSkuTable');
        $skuList = $OnyxSkuTable->fetchAll();
        $return = array(
            'skuList' => $skuList
        );
        $flashMessenger = $this->flashMessenger();
        if ($flashMessenger->hasMessages()) {
            $return['messages'] = $flashMessenger->getMessages();
        }
        return new ViewModel($return);
    }
    
    public function createallAction(){
        $OnyxSkuTable = $this->getModelResource('OnyxSkuTable');
        $OnyxCodeTable = $this->getModelResource('OnyxCodeTable');
        
        $skuList = $OnyxSkuTable->fetchAll();
        foreach($skuList as $sku){      
            if(!$sku->completed){
                $count = 0;
                $togo = $sku->needed - $sku->created;
                for($i = 0; $i < $togo; $i++){
                    $code = \OnyxSystem\DataFunctions::keygen();
                    $onyxCode = new OnyxCode();
                    $onyxCode->code = $code;
                    $onyxCode->prize = $sku->name;
                    $onyxCode->sku_id = $sku->id;
                    try{
                        $OnyxCodeTable->save($onyxCode);
                        $count++;
                    }catch(Exception $e){
                    }
                    if($count >= 5000){
                        $sku->created = ($sku->created + $count);
                        if($sku->created >= $sku->needed){
                            $sku->completed = 1;
                        }
                        $OnyxSkuTable->save($sku);
                        return $this->redirect()->toRoute('system-code-create-all');
                    }     
                                  

                }
                $sku->created = ($sku->created + $count);
                if($sku->created == $sku->needed){
                    $sku->completed = 1;
                }
                $OnyxSkuTable->save($sku);
                $this->flashMessenger()->addMessage($sku->created .' codes added to '.$sku->name);
            }
        }        
        
        return $this->redirect()->toRoute('system-code');
    }
    
    public function clicreateallAction(){
        $request = $this->getRequest();
 
        // Make sure that we are running in a console and the user has not tricked our
        // application into running this action from a public web server.
        if (!$request instanceof ConsoleRequest){
            throw new \RuntimeException('You can only use this action from a console!');
        }
        
        echo ini_get("memory_limit")."\n";
        ini_set("memory_limit","2048M");
        echo ini_get("memory_limit")."\n";
 
        $OnyxSkuTable = $this->getModelResource('OnyxSkuTable');
        $OnyxCodeTable = $this->getModelResource('OnyxCodeTable');
        
        $skuList = $OnyxSkuTable->fetchAll();
        foreach($skuList as $sku){      
            if(!$sku->completed){
                $count = 0;
                $togo = $sku->needed - $sku->created;
                for($i = 0; $i < $togo; $i++){
                    $code = \OnyxSystem\DataFunctions::keygen();
                    $onyxCode = new OnyxCode();
                    $onyxCode->code = $code;
                    $onyxCode->prize = $sku->name;
                    $onyxCode->sku_id = $sku->id;
                    try{
                        $OnyxCodeTable->save($onyxCode);
                        $count++;
                    }catch(Exception $e){
                    }                    
                    $onyxCode = null;
                }
                $sku->created = ($sku->created + $count);
                if($sku->created == $sku->needed){
                    $sku->completed = 1;
                }
                $OnyxSkuTable->save($sku);
                echo $sku->created .' codes added to '.$sku->name."\r\n";
            }
        }  
        
    }
    
    public function generateAction(){
        $id = $this->params()->fromRoute('id');
        $OnyxSkuTable = $this->getModelResource('OnyxSkuTable');
        $OnyxCodeTable = $this->getModelResource('OnyxCodeTable');
        $sku = $OnyxSkuTable->getById($id);
        $count = 0;        
        $togo = $sku->needed - $sku->created;
        for($i = 0; $i < $togo; $i++){
            $code = \OnyxSystem\DataFunctions::keygen();
            $onyxCode = new OnyxCode();
            $onyxCode->code = $code;
            $onyxCode->prize = $sku->name;
            $onyxCode->sku_id = $sku->id;
            try{
                $OnyxCodeTable->save($onyxCode);
                $count++;
            }catch(Exception $e){
            }
            if($count >= 5000){
                $sku->created = ($sku->created + $count);
                if($sku->created >= $sku->needed){
                    $sku->completed = 1;
                }
                $OnyxSkuTable->save($sku);
                return $this->redirect()->toRoute('system-code-generate', array(
                    'controller' => 'code',
                    'action' =>  'genergare',
                    'id' => $id
                ));
            }     
            
        }
        $sku->created = ($sku->created + $count);
        if($sku->created == $sku->needed){
            $sku->completed = 1;
        }
        $OnyxSkuTable->save($sku);
        $this->flashMessenger()->addMessage($sku->created .' codes added to '.$sku->name);
        return $this->redirect()->toRoute('system-code');
    }
    
    
    
    private function getModelResource($model){
        if (!isset($this->table[$model])) {
            $sm = $this->getServiceLocator();
            $this->table[$model] = $sm->get($model);
        }
        return $this->table[$model];
    }



}
