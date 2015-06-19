<?php
namespace Play\V1\Rpc\Play;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class PlayController extends AbstractActionController
{
    public $board,$allmoves;

    public function playAction()
    {

        $this->board = array();
        $this->initBoard();  // first task load board from save game

        $mk = $this->readPos('king.txt');
        $mk = explode('|', $mk);//print_r($mk);
        $n = file_get_contents('order.txt');
        //print_r($_REQUEST);
        $okm = $_REQUEST['m'];
        $okm = explode('|', $okm);$okm[0]-=1;$okm[1]-=1;
        $this->showBoard($n);

        if ($this->botmoveValid($this->board, $okm[0], $okm[1])) {
            $this->setMoved($okm[0], $okm[1]);
        }
        else if(0) {
            return new ViewModel(array(
                'm' => false,
                'I WIN' => "YOU SUCK!"
            ));
        }
/*
////////////  CHECKING STALEMATE /////////////////
//print_r($mk); print_r($okm); print_r($mk[0]-1-$okm[0]); print_r(abs($mk[1]-1-$okm[1]));
        if(abs($mk[0]-$okm[0]) == 1 || abs($mk[1]-$okm[1]) == 1) {
            // EXECUTE THE FUCKING CHECKMATE
            //echo 'stalemate';
            return new ViewModel(array(
                'm' => ($okm[0] + 1) . '|' . ($okm[1] + 1)
            ));


        }

*/

        ///// CALCULATING MOVES //////////////////////////////////////////////////////////////////////

        $this->allmoves = array();
        $origx = $mk[0];
        $origy = $mk[1];
        $movea;$moveb;
        $this->calcMoves($this->board, $mk[0]-1,$mk[1]-1,$n);//moves($board,$cx,$cy);

        ////////////////////////////////////////////////////////////////////////////////////////////////////////


        $this->showBoard($n);
        $move = array();
        $move = $this->attack($this->allmoves,$okm[0],$okm[1]);
//print_r($move);
        $this->setMoved($move['x'],$move['y']);

        $this->showBoard($n);

        // last task
         $this->saveGame();$mk[0] = $move['x']+1;$mk[1] = $move['y']+1;
        $this->savePos('king.txt', implode('|', $mk));


        // functions



        return new ViewModel(array(
            'm' => ($move['x']+1) . '|' . ($move['y']+1)
        ));
    }

    function botmoveValid($board, $a, $b)
    {

        if ($board[$a][$b] == 1) {

            return false;

        } else {

            return true;
        }

    }

    public function savePos($file,$cont){
        file_put_contents($file,serialize($cont));
    }


    public function readPos($file)
    {
        return unserialize(file_get_contents($file));
    }

    public function initBoard()
    {
        $this->board = unserialize(file_get_contents('save.txt'));
    }

    public function saveGame()
    {
        file_put_contents('save.txt', serialize($this->board));
    }

    public function setMoved($a, $b)
    {
        $this->board[$a][$b] = 1;
    }

    public function showBoard($order)
    {
        //echo "Board is : ";
        //print_r($this->board);
        for ($i = 0; $i < $order; $i++) {
            for ($j = 0; $j < $order; $j++)
                ;//echo $this->board[$i][$j] . "  ";

            //echo '<br >';
        }
    }



















    //------------------------possible moves -------------

    function possmoves($n, $board, $origx, $origy, $cx, $cy)
    {
         //, $pmoves;
        $x1 = $cx - 1;
        $x2 = $cx + 1;
        $y1 = $cy - 1;
        $y2 = $cy + 1;
        $count = 0;
        //$pmove = array(); // contains the local moves
//----1st case
        if ($x1 >= 0 && $board[$x1][$cy] != 1) {
            if ($origx != $x1 || $origy != $cy) {
                $count++;
            }
        }
//---2nd case
        if ($y2 <= $n && $x1 >= 0 && $board[$x1][$y2] != 1) {
            if ($origx != $x1 || $origy != $y2) {
                $count++;
            }
        }
//-----------3rd case
        if ($y2 <= $n && $board[$cx][$y2] != 1) {
            if ($origx != $cx || $origy != $y2) {
                $count++;
            }
        }
//-----------4th case
        if ($y2 <= $n && $x2 <= $n && $board[$x2][$y2] != 1) {
            if ($origx != $x2 || $origy != $y2) {
                $count++;
            }
        }
//-----------5th case
        if ($x2 <= $n && $board[$x2][$cy] != 1) {
            if ($origx != $x2 || $origy != $cy) {
                $count++;
            }
        }
//-----------6th case
        if ($y1 >= 0 && $x2 <= $n && $board[$x2][$y1] != 1) {
            if ($origx != $x2 || $origy != $y1) {
                $count++;
            }
        }
//-----------7th case
        if ($y1 >= 0 && $board[$cx][$y1] != 1) {
            if ($origx != $cx || $origy != $y1) {
                $count++;
            }
        }
//-----------8th case
        if ($x1 >= 0 && $y1 >= 0 && $board[$x1][$y1] != 1) {
            if ($origx != $x1 || $origy != $y1) {
                $count++;
            }
        }


        return $count;


    }

    function calcMoves($board, $cx, $cy,$n)
    {$n--;
        //echo 'ypyp';//print_r($board);
        //$this->allmoves;
        $x1 = $cx - 1;
        $x2 = $cx + 1;
        $y1 = $cy - 1;
        $y2 = $cy + 1; //echo $cx. $x1 . $x2 . $y1 . $y2;
        $moves = array();
        $pmove = array(); // contains the local moves
//----1st case
        if ($x1 >= 0 && $board[$x1][$cy] != 1) {
            $pmove[0][0] = $x1;
            $pmove[0][1] = $cy;
            array_push($moves, $x1 . ':' . $cy . ':' . $this->possmoves($n, $board, $cx, $cy, $x1, $cy));
        }
//---2nd case
        if ($y2 <= $n && $x1 >= 0 && $board[$x1][$y2] != 1) {
            $pmove[1][0] = $x1;
            $pmove[1][1] = $y2;
            $moves[count($moves)] = $x1 . ':' . $y2 . ':' . $this->possmoves($n, $board, $cx, $cy, $x1, $y2);
        }
//-----------3rd case
        if ($y2 <= $n && $board[$cx][$y2] != 1) {
            $pmove[2][0] = $cx;
            $pmove[2][1] = $y2;
            $moves[count($moves)] = $cx . ':' . $y2 . ':' . $this->possmoves($n, $board, $cx, $cy, $cx, $y2);
        }
//-----------4th case
        if ($y2 <= $n && $x2 <= $n && $board[$x2][$y2] != 1) {
            $pmove[3][0] = $x2;
            $pmove[3][1] = $y2;
            $moves[count($moves)] = $x2 . ':' . $y2 . ':' . $this->possmoves($n, $board, $cx, $cy, $x2, $y2);
        }
//-----------5th case
        if ($x2 <= $n && $board[$x2][$cy] != 1) {
            $pmove[4][0] = $x2;
            $pmove[4][1] = $cy;
            $moves[count($moves)] = $x2 . ':' . $cy . ':' . $this->possmoves($n, $board, $cx, $cy, $x2, $cy);
        }
//-----------6th case
        if ($y1 >= 0 && $x2 <= $n && $board[$x2][$y1] != 1) {
            $pmove[5][0] = $x2;
            $pmove[5][1] = $y1;
            $moves[count($moves)] = $x2 . ':' . $y1 . ':' . $this->possmoves($n, $board, $cx, $cy, $x2, $y1);
        }
//-----------7th case
        if ($y1 >= 0 && $board[$cx][$y1] != 1) {
            $pmove[6][0] = $cx;
            $pmove[6][1] = $y1;
            $moves[count($moves)] = $cx . ':' . $y1 . ':' . $this->possmoves($n, $board, $cx, $cy, $cx, $y1);
        }
//-----------8th case
        if ($x1 >= 0 && $y1 >= 0 && $board[$x1][$y1] != 1) {
            $pmove[7][0] = $x1;
            $pmove[7][1] = $y1;
            $moves[count($moves)] = $x1 . ':' . $y1 . ':' . $this->possmoves($n, $board, $cx, $cy, $x1, $y1);
        }
        $this->allmoves = $moves;
////print_r($moves);
////print_r($pmove);

    }

////////////// ATTTTAAAACCCCCCCCCCKKKKKKKKKKKKKK BIZSNATCH //////////////////////////////


    public function attack($allmoves,$opos1,$opos2){
        $pos = array();
        $splitallmove = array();
//print_r($allmoves);

        for ($i=0; $i<count($allmoves);$i++){

            $splitallmove = explode(":",$allmoves[$i]);

            for($j=0; $j<3; $j++){

                $pos[$i][$j] = $splitallmove[$j];
            }

        }
        $distx = array();

        for($i=0;$i<count($pos);$i++){
            $distx[$i]= sqrt((abs($pos[$i][0]-$opos1)*abs($pos[$i][0]-$opos1)+10*abs($pos[$i][1]-$opos2)*abs($pos[$i][1]-$opos2)))+.3*$pos[$i][2];
            if($distx==1 || $distx == sqrt(2)){
                return (array("x"=>$opos1,"y"=>$opos2));
            }

//echo $pos[$i][2];
        }
//print_r($distx);
        //echo "..".count($distx)."...";

        $greatest = 0;
        $indexOfGreatest =0;
        for ($i = 0; $i < count($distx); $i++) {
            if (!$greatest || $distx[$i] > $greatest) {
                $greatest = $distx[$i];
                $indexOfGreatest = $i;
            }
        }
        $nextx = $pos[$indexOfGreatest][0];
        $nexty = $pos[$indexOfGreatest][1];
        //echo $nextx."::";
        //echo $nexty;
        return (array("x"=>$nextx,"y"=>$nexty));
////print_r($pos);

    }






















}
