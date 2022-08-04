<?php
require_once __DIR__.'/../db/src/litterbox.class.php';

use HomeIntranet\Database\LitterBox;

$db = new LitterBox();

$fosters = $db->getDisabledFosters();

foreach ($fosters['data'] as $key => $value) {
  if(strtotime($value['foster_date_disabled'] . "+14days") < time()){
    $db->removeFoster($value['foster_id']);
  }
}