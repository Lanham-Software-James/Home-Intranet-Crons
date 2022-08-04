<?php
require_once __DIR__.'/../db/src/greenhouse.class.php';

use HomeIntranet\Database\Greenhouse;

$db = new Greenhouse();

$plants = $db->getDisabledPlants();

foreach ($plants['data'] as $value) {
  if(strtotime($value['plant_date_disabled'] . "+14days") < time()){
    $db->removePlant($value['plant_id']);
  }
}

$locations = $db->getDisabledLocations();

foreach ($locations['data'] as $value) {
  if(strtotime($value['location_date_disabled'] . "+14days") < time()){
    $db->removeLocation($value['location_id']);
  }
}

$species = $db->getDisabledSpecies();

foreach ($species['data'] as $value) {
  if(strtotime($value['species_date_disabled'] . "+14days") < time()){
    $db->removeSpecies($value['species_id']);
  }
}