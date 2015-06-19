<?php
namespace Start\V1\Rpc\Start;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class StartController extends AbstractActionController
{
    public $board;
    public function startAction()
    {
        $this->board=array();
        $mk = $_REQUEST['y'];
        $ok = $_REQUEST['o'];
        $order = $_REQUEST['g'];
        $this->savePos('king.txt', $mk);
        $this->savePos('oking.txt', $ok);
        file_put_contents('order.txt',$order);
        $mk = explode('|',$mk);
        $ok = explode('|',$ok);

        // initialize board to zeroes
        $this->initBoard($mk[0]-1, $mk[1]-1, $ok[0]-1, $ok[1]-1, $order);

        //print_r($_REQUEST);

        $this->showBoard($order);

        // final task
        $this->saveGame();
        return new ViewModel(array('ok' => true));
    }

    public function initBoard($mka, $mkb, $oka, $okb, $order){
        for($i=0;$i<$order; $i++)
            for($j=0;$j<$order;$j++)
                $this->board[$i][$j]=0;

        $this->setMoved($mka,$mkb);
        $this->setMoved($oka,$okb);
    }

    public function savePos($file,$cont){
        file_put_contents($file,serialize($cont));
    }

    public function saveGame(){
        file_put_contents('save.txt', serialize($this->board));
    }

    public function setMoved($a,$b){
        $this->board[$a][$b] = 1;
    }

    public function showBoard($order){
       // echo "Board is : ";//print_r($this->board);
        for($i=0;$i<$order; $i++) {
            for ($j = 0; $j < $order; $j++)
               ;// echo $this->board[$i][$j] . "  ";

            //echo '<br >';
        }
    }

}
