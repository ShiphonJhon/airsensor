<?php
  $json = file_get_contents("php://input");
  $contents = json_decode($json, true);

  $datetime = $contents["datetime"];
  $Temp = $contents["Temp"];
  $Hum = $contents["Hum"];
  $DeviceID = $contents["DeviceID"];

  try{
    $pdo = new PDO('mysql:dbname=sensorDB; host=lamp-dock_mysql_1;', 'root', 'root');
  }catch(PDOException $e){
    exit( "error:" . $e->getMessage());
  }

  $stmt = $pdo->prepare("insert into sensorTBL02(datetime, Temp, Hum, DeviceID ) values( :datetime, :Temp, :Hum, :DeviceID )");
  if(!$stmt){
    $info = $pdo->errorInfo();
    exit($info[2]);
  }

  $stmt->bindValue(':datetime', $datetime, PDO::PARAM_STR );
  $stmt->bindValue(':Temp', $Temp, PDO::PARAM_STR );
  $stmt->bindValue(':Hum', $Hum, PDO::PARAM_STR );  
  $stmt->bindValue(':DeviceID', $DeviceID, PDO::PARAM_STR);

  $stmt->execute();

echo "success";
?>

 
