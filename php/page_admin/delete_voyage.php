<?php

if (!isset($_GET['id'])) {
  header('Location: ./index.php');
  exit;
}

require_once('../../php_utils/csv.php');
$voyages = read_csv('../../data/voyages.csv');
$index = array_find_key($voyages, fn($v) => $v['id'] == $_GET['id']);
$voyage = $voyages[$index];

if (!isset($voyage)) {
  header('Location: ./index.php');
  exit;
}

unset($voyages[$index]);
write_csv($voyages, '../../data/voyages.csv');
header('Location: ./index.php');
exit;
