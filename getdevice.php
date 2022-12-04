<?php

  try{
    $pdo = new PDO('mysql:dbname=sensorDB; host=lamp-dock_mysql_1;', 'root', 'root');
  }catch(PDOException $e){
    exit( "データベースに接続できませんでした。" . $e->getMessage());
  }

  $stmt = $pdo->query('SET NAMES utf8');
  if(!$stmt){
    $info = $pdo->errorInfo();
    exit($info[2]);
  }

  $stmt = $pdo->prepare("select distinct DeviceID from sensorTBL02");
  if(!$stmt){
    $info = $pdo->errorInfo();
    exit($info[2]);
  }

  $flag = $stmt->execute();
  if(!$flag){
    $info = $stmt->errorInfo();
    exit($info[2]);
  }

  $dataArr = [];

  while( $data = $stmt->fetch( PDO::FETCH_ASSOC )){
    //    echo '<p>' . $data["datetime"] . ":" . $data["Temp"] . ":" . $data["Hum"] . ":" . $data["DeviceID"] . "</p>\n";
    array_push($dataArr, $data);
  }

  $pdo = null;

  $jsonStr = json_encode($dataArr);
//  echo var_dump($jsonStr);
  echo $jsonStr;
?>
