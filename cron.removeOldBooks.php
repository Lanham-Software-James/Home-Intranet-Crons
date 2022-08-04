<?php
require_once __DIR__.'/../db/src/library.class.php';

use HomeIntranet\Database\Library;

$db = new Library();

$books = $db->getDisabledBooks();

foreach ($books['data'] as $key => $value) {
  if(strtotime($value['book_date_disabled'] . "+14days") < time()){
    $db->removeBook($value['book_id']);
  }
}

$authors = $db->getDisabledAuthors();

foreach ($authors['data'] as $key => $value) {
  if(strtotime($value['author_date_disabled'] . "+14days") < time()){
    $db->removeAuthor($value['author_id']);
  }
}