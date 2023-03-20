<?php
require_once __DIR__.'/../db/src/fitbit.class.php';

use HomeIntranet\Database\FitBit;

$ini = parse_ini_file(__DIR__ . "/fitbit.ini");

$db = new FitBit();

$day = date("N");
$steps = 0;
$goals = $db->getStepGoals();

switch ($day) {
  case 1: //Monday
    $steps = $goals['data'][0]['step_goal_count'];    
    break;
  
  case 2: //Tuesday
    $steps = $goals['data'][1]['step_goal_count'];    
    break;

  case 3: //Wednesday
    $steps = $goals['data'][0]['step_goal_count'];    
    break;
  
  case 4: //Thursday
    $steps = $goals['data'][3]['step_goal_count'];    
    break;
  
  case 5: //Friday
    $steps = $goals['data'][2]['step_goal_count'];    
    break;

  case 6: //Saturday
    $steps = $goals['data'][3]['step_goal_count'];    
    break;
  
  case 7: //Sunday
    $steps = $goals['data'][4]['step_goal_count'];    
    break;
  
  default:
    
    break;
}


$curl = curl_init($ini['url'] . $steps);

$body = [
  'Authorization'    => 'Bearer ' . $ini['access_code']
];

curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl,  CURLOPT_HTTPHEADER, [
  "Authorization: Bearer " . $ini['access_code'],
  "Content-Length: 0"
]);

curl_exec($curl);

curl_close($curl);
