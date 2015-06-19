<?php
namespace ping\V1\Rpc\Ping;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class PingController extends AbstractActionController
{
    public function pingAction()
    {
        //print_r($_REQUEST);
        return new ViewModel(array(
            'ok' => true
        ));
    }
}
