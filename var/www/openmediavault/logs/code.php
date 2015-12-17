<?php
//Restituisce due array, uno con i nomi dei computer e uno con gli url dei log.
foreach(glob($_SERVER["DOCUMENT_ROOT"]."/".basename(dirname($_SERVER['PHP_SELF']))."/*.txt") as $id => $filename){
	if(basename($filename) != "output.txt"){
		$nomeComputer[$id] = substr(basename($filename),0,-4);
		$urls[] = basename($filename);
	}
}
//Se è settato l'id recupera il nome dal GET, apre il log e crea gli array relativi ai valori interni.
/*if(isset($_GET['computer']) && $_GET['computer'] = 'show'){
	$txt_file    = file_get_contents($_GET['id'].'.txt');
	$rows        = explode(":", $txt_file);
	
	$nome = substr($rows[1],2,-9);
	$dimensione = number_format(substr(trim($rows[20]),1,-3),2,",",".");
	$checkLetteraDim = substr(trim($rows[20]),-3,1);
	$accesso = substr($rows[11].":".$rows[12].":".substr($rows[13],0,-8),0,20);
	$ultimaModifica = substr($rows[14].":".$rows[15].":".substr($rows[16],0,-8),0,20);
	$oggi = date('Y-m-d H:m:i',time());
	$diff = abs(strtotime($oggi) - strtotime($ultimaModifica));
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
}*/

$results = array();

foreach($urls as $index => $url)
{
    $results[] = file_get_contents($url);
}

$row2 = implode(" ",$results);
$row2 = explode(" ",$row2);
$row2 = array_filter( $row2 );
$row2 = array_slice($row2,0);
$a = 1;$b = 3;$c = 23;$d = 29;$e = 33;
foreach($results as $value2){
	$computers[] = basename($row2[$a]);
	$size[] = number_format(substr($row2[$e],2,-4),2,',','.');
	$last_access[] = substr($row2[$c]. " ".$row2[$c+1],0,19);
	$last_modify[] = substr($row2[$d]. " ".$row2[$d+1],0,19);
	$checkLetteraDim[] = substr(substr($row2[$e],-4),0,-3);
	$error[] = checkLastAccess($row2[$d]);
	$a += 34;$b += 34;$c += 34;$d += 34;$e += 34;
}
function checkLastAccess($c) {
	$oggi = date('Y-m-d',time());
	$diff = abs(strtotime($oggi) - strtotime($c));
	if( floor($diff / (60*60*24)) > 10 ){
		return 1;
	}
	else{
		return 2;
	}
}
switch($_SESSION['checkLetter'])
{
	case "T":
	switch($checkLetteraDim)
	{
		case "T":
		$folder_precent = number_format(($dimensione / $_SESSION['totalSpace'])*100,2);
		break;
		
		case "G":
		$folder_precent = number_format((($dimensione / 1024) / $_SESSION['totalSpace'])*100,2);
		break;
		
		case "M":
		$folder_precent = number_format(((($dimensione / 1024) / 1024) / $_SESSION['totalSpace'])*100,2);
		break;		
		
		case "K":
		$folder_precent = number_format((((($dimensione / 1024) / 1024) / 1024) / $_SESSION['totalSpace'])*100,2);
		break;
		
		default:
		$folder_precent = "ERRORE DI CALCOLO";
		break;
	}
	break;
	
	case "G":
	switch($checkLetteraDim)
	{
		case "G":
		$folder_precent = number_format(($dimensione / $_SESSION['totalSpace'])*100,2);
		break;
		
		case "M":
		$folder_precent = number_format((($dimensione / 1024) / $_SESSION['totalSpace'])*100,2);
		break;
		
		case "K":
		$folder_precent = number_format(((($dimensione / 1024) / 1024) / $_SESSION['totalSpace'])*100,2);
		break;		
		
		default:
		$folder_precent = "ERRORE DI CALCOLO";
		break;
	}
	break;	
}
?>
