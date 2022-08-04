<?php
require_once __DIR__.'/../db/src/user.class.php';

use HomeIntranet\Database\User;

$db = new User();

$logs = $db->getLogsAllCron();

foreach ($logs['data'] as $key => $value) {
  if(strtotime($value['log_date_time'] . "+14days") < time()){
    $db->removeLogEntry($value['log_id']);
  }
}