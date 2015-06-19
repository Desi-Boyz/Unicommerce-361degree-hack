<?php
header("Content-type: text/plain");
$board = array();

$n = 15;

$cx;
$cy;

//-------------------------- board creation --------------------------

initboard($n);

function initboard($n){
global $board;

for($i=0;$i<$n;$i++)
{
	for($j=0;$j<$n;$j++)
	{
		$board[$i][$j] = 0;
	
	}

}

}

$o = "5|5";
$m = "2|2";


turn($m,$board);

//--------------------- oppo bot move ---------------------------

function turn($m,$board){

global $n;

$msplit = explode("|",$m);

echo $msplit[0].":";
echo $msplit[1];
 
$a = $msplit[0]-1;
$b = $msplit[1]-1;

global $cx;
$cx = $a;

global $cy;
$cy = $b;

if($a>$n || $a < 0 || $b>$n || $b < 0 ){
	
	
}

else{
	
	$board[$a][$b] = 1;

}

}

//------------------------------------ our bot move ----------------------------

function botmove($board,$a,$b){
	
if($board[$a][$b] == 1){
	
	return false; 

	}	

else {
	
	return true;
	}	
	
}
$allmoves = array();
$origx = $cx;
$origy = $cy;
calcMoves($board, $cx, $cy);//moves($board,$cx,$cy);
//------------------------possible moves -------------

function possmoves($board,$origx,$origy, $cx, $cy){
	global $n,$pmoves;
	$x1 = $cx-1;
	$x2 = $cx+1;
	$y1 = $cy - 1;
	$y2 = $cy + 1;
	$count=0;
	//$pmove = array(); // contains the local moves
//----1st case
if($x1 >= 0 && $board[$x1][$cy]!=1)	{
  if($origx != $x1 || $origy != $cy){
	$count++;
  }
}
//---2nd case
if( $y2<=$n && $x1>=0 && $board[$x1][$y2]!=1 ){
	if($origx != $x1 || $origy != $y2){
	$count++;
  }
}
//-----------3rd case
if( $y2<=$n && $board[$cx][$y2]!=1){
	if($origx != $cx || $origy != $y2){
	$count++;
  }
}
//-----------4th case
if($y2<=$n && $x2<=$n && $board[$x2][$y2]!=1){
	if($origx != $x2 || $origy != $y2){
	$count++;
  }
}
//-----------5th case
if( $x2<=$n && $board[$x2][$cy]!=1){
	if($origx != $x2 || $origy != $cy){
	$count++;
  }
}
//-----------6th case
if( $y1>=0 && $x2<=$n && $board[$x2][$y1]!=1){
	if($origx != $x2 || $origy != $y1){
	$count++;
  }
}
//-----------7th case
if($y1>=0 && $board[$cx][$y1]!=1 ){
	if($origx != $cx || $origy != $y1){
	$count++;
  }
}
//-----------8th case
if( $x1>=0 &&  $y1>=0 && $board[$x1][$y1]!=1){
	if($origx != $x1 || $origy != $y1){
	$count++;
  }
}



return $count;
	
	
	
}

function calcMoves($board, $cx, $cy) {
	global $n, $allmoves;
	$x1 = $cx-1;
	$x2 = $cx+1;
	$y1 = $cy - 1;
	$y2 = $cy + 1;$moves = array();
	$pmove = array(); // contains the local moves
//----1st case
if($x1 >= 0 && $board[$x1][$cy]!=1)	{
	$pmove[0][0] = $x1;
	$pmove[0][1] = $cy;
	array_push($moves, $x1.':'.$cy.':'.possmoves($board,$cx, $cy,$x1,$cy));
}
//---2nd case
if( $y2<=$n && $x1>=0 && $board[$x1][$y2]!=1 ){
	$pmove[1][0] = $x1;
	$pmove[1][1] = $y2;
	$moves[count($moves)] = $x1.':'.$y2.':'.possmoves($board,$cx, $cy,$x1,$y2);
}
//-----------3rd case
if( $y2<=$n && $board[$cx][$y2]!=1){
	$pmove[2][0] = $cx;
	$pmove[2][1] = $y2;
	$moves[count($moves)] = $cx.':'.$y2.':'.possmoves($board,$cx, $cy,$cx,$y2);
}
//-----------4th case
if($y2<=$n && $x2<=$n && $board[$x2][$y2]!=1){
	$pmove[3][0] = $x2;
	$pmove[3][1] = $y2;
	$moves[count($moves)] = $x2.':'.$y2.':'.possmoves($board,$cx, $cy,$x2,$y2);
}
//-----------5th case
if( $x2<=$n && $board[$x2][$cy]!=1){
	$pmove[4][0] = $x2;
	$pmove[4][1] = $cy;
	$moves[count($moves)] = $x2.':'.$cy.':'.possmoves($board,$cx, $cy,$x2,$cy);
}
//-----------6th case
if( $y1>=0 && $x2<=$n && $board[$x2][$y1]!=1){
	$pmove[5][0] = $x2;
	$pmove[5][1] = $y1;
	$moves[count($moves)] = $x2.':'.$y1.':'.possmoves($board,$cx, $cy,$x2,$y1);
}
//-----------7th case
if($y1>=0 && $board[$cx][$y1]!=1 ){
	$pmove[6][0] = $cx;
	$pmove[6][1] = $y1;
	$moves[count($moves)] = $cx.':'.$y1.':'.possmoves($board,$cx, $cy,$cx,$y1);
}
//-----------8th case
if( $x1>=0 &&  $y1>=0 && $board[$x1][$y1]!=1){
	$pmove[7][0] = $x1;
	$pmove[7][1] = $y1;
	$moves[count($moves)] = $x1.':'.$y1.':'.possmoves($board,$cx, $cy,$x1,$y1);
}
$allmoves = $moves;
//print_r($moves);
//print_r($pmove);
	
}

attack();

function attack(){
	
	global $o ;
	global $allmoves;
	$osplit = explode("|",$o);
	$pos = array();
	$splitallmove = array();
	
 
	$opos1 = $osplit[0]-1;
	$opos2 = $osplit[1]-1;
	
	for ($i=0; $i<count($allmoves);$i++){
		
		$splitallmove = explode(":",$allmoves[$i]);
		
		for($j=0; $j<3; $j++){
			
		$pos[$i][$j] = $splitallmove[$j];			
		}
		
	}	
	$distx = array();
	for($i=0;$i<count($pos);$i++){
	$distx[$i]= sqrt((abs($pos[$i][0]-$opos1)*abs($pos[$i][0]-$opos1)+abs($pos[$i][1]-$opos2)*abs($pos[$i][1]-$opos2)))+$pos[$i][2];
		
	}
	
	echo "..".count($distx)."...";
	
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
	echo $nextx."::";
	echo $nexty;
//print_r($pos);	
	
}

//print_r($allmoves);


?>