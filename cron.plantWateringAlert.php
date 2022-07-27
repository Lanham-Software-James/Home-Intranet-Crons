<?php
require_once __DIR__.'/../db/src/greenhouse.class.php';

use HomeIntranet\Database\Greenhouse;

$ini = parse_ini_file(__DIR__ . "/notifyMe.ini");

$db = new Greenhouse();

$plants = $db->getPlants();

$plantsWatered = [];

$notification = "";

foreach ($plants['data'] as $key => $value) {

  $date = null;

  switch ($value['water_frequency']) {
    case 'Daily':
      $date = date('Y-m-d', strtotime($value['last_watered'] . "+1 day"));
      break;

    case 'Every Other Day':
      $date = date('Y-m-d', strtotime($value['last_watered'] . "+2 days"));
      break;

    case 'Weekly':
      $date = date('Y-m-d', strtotime($value['last_watered'] . "+1 week"));
      break;

    case 'Bi-Weekly':
      $date = date('Y-m-d', strtotime($value['last_watered'] . "+2 week"));
      break;

    case 'Tri-Weekly':
      $date = date('Y-m-d', strtotime($value['last_watered'] . "+3 week"));
      break;

    case 'Monthly':
      $date = date('Y-m-d', strtotime($value['last_watered'] . "+1 month"));
      break;
    
    default:
      break;
  }

  if($date == date('Y-m-d', time())){
    if($notification == ""){
      $notification = "Water the following plants: " . $value['plant_name'];
    } else {
      $notification = $notification . ", " . $value['plant_name'];
    }

    array_push($plantsWatered, $value['plant_id']);
  }
}

if($notification != ""){
  $curl = curl_init($ini['url']);

  $body = [
    'notification'  => $notification,
    'accessCode'    => $ini['access_code']
  ];

  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl,  CURLOPT_POSTFIELDS, json_encode($body));

  curl_exec($curl);

  curl_close($curl);

  foreach ($plantsWatered as $key => $value) {
    $db->waterPlant($value);
  }
}