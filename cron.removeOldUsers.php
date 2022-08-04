<?php
require_once __DIR__.'/../db/src/user.class.php';

use HomeIntranet\Database\User;

$db = new User();

$users = $db->getDisabledUsers();

foreach ($users['data'] as $key => $value) {
  if(strtotime($value['user_date_disabled'] . "+14days") < time()){
    $db->removeUser($value['user_id']);
  }
}