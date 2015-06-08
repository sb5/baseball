<?php
 header('Access-Control-Allow-Origin: *');  
 
 
include('connect.php');
$filter = '';
if(isset($_GET['left_filter']) && $_GET['left_filter'] ==1 ){$filter = "Where `throws` = 'left'";}
if(isset($_GET['list_pitchers'])){

$sql = "SELECT `name_last`, `name_first`, `mlbid` from `TABLE 1` ".$filter;
 



$a = $dbh->prepare($sql);
$a->execute();
while($row = $a->fetch(PDO::FETCH_ASSOC)){

$newarray[]= $row;

}


}

elseif(isset($_GET['list_games'])){

$sql = "SELECT  `game_id`, `date` from `TABLE 1` ".$filter;
// $a = mysql_query($sql) or die (mysql_error());

$a = $dbh->prepare($sql);
$a->execute();
while($row = $a->fetch(PDO::FETCH_ASSOC)){

$newarray[]= $row;

}


}elseif(isset($_GET['list_pitchers_by_id'])){



$id = $_GET['list_pitchers_by_id'];


$sql = "SELECT  * from `TABLE 1`  where `mlbid` = ?";
// $a = mysql_query($sql) or die (mysql_error());

$a = $dbh->prepare($sql);
$a->bindParam(1, $id);



$a->execute();


$ptarray = array(
'AB',
'CH',
'CS',
'CU',
'FA',
'FC',
'FS',
'IB',
'KN',
'PO',
'SB',
'SI',
'SL',
'XX');



 if($a->rowCount() > 0){

while($row = $a->fetch(PDO::FETCH_ASSOC)){


foreach($ptarray as $pt){
if( $row['pitch_type'] == $pt){
$mainarray['date'][$row['game_id']]['total'] +=1;
$mainarray['date'][$row['game_id']][$pt] +=1;

// 
$mainarray['date'][$row['game_id']]['swing'][$pt] = $row['swing'];
$mainarray['date'][$row['game_id']]['total_pitch_type'][$pt] += 1;
$mainarray['date'][$row['game_id']]['pitch_speed'][$pt] += $row['pitch_speed'];
$mainarray['date'][$row['game_id']]['horizontal_movement'][$pt] += $row['horizontal_movement'];

$mainarray['date'][$row['game_id']]['vertical_movement'][$pt] += $row['vertical_movement'];
$mainarray['date'][$row['game_id']]['spin_rate'][$pt] += $row['spin_rate'];

 
}



}






}

foreach($mainarray as $main=>$array){
foreach($array as $k=>$v){
 $newarray[$k]['date'] = $k;
$newarray[$k]['total'] = $v['total'];

foreach($v['pitch_speed'] as $z=>$x){
 
$newarray[$k][$z]['pitch_speed'] = $x/$v[$z];
}
foreach($v['total_pitch_type'] as $z=>$x){
 
$newarray[$k][$z]['total_pitch_type'] = $x;
}
foreach($v['vertical_movement'] as $z=>$x){
 
$newarray[$k][$z]['vertical_movement'] = $x/$v[$z];
}
foreach($v['horizontal_movement'] as $z=>$x){
 
$newarray[$k][$z]['horizontal_movement'] = $x/$v[$z];
}
foreach($v['spin_rate'] as $z=>$x){
 
$newarray[$k][$z]['spin_rate'] = $x/$v[$z];
}

foreach($v['swing'] as $z=>$x){
 
$newarray[$k][$z]['swing'] = $x/$v[$z];
}


}
}



}
else{
header("HTTP/1.0 404 Not Found"); 
}


}

 echo json_encode($newarray);
 
?>