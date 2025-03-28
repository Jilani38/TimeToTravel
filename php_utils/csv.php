<?php

$names = array('id', 'titre', 'date', 'lieu', 'image');

function read_csv(string $path): array {
  global $names;
  $rows = file('../../data/voyages.csv');
  $csv = [];
  for($i = 1; $i < count($rows); $i++) {
    $row = str_getcsv($rows[$i], ';', '"', "");
    for ($j = 0; $j < count($names); $j++) {
      $csv[$i - 1][$names[$j]] = $row[$j];
    }
  }
  return $csv;
}

function write_csv(array $csv, string $path) {
  global $names;
  $rows = [];
  for ($i = 0; $i < count($csv); $i++) {
    $row = [];
    for ($j = 0; $j < count($names); $j++) {
      $row[] = $csv[$i][$names[$j]];
    }
    $rows[] = implode(';', $row);
  }
  $csv = implode(';', $names) . "\n" . implode("\n", $rows);
  file_put_contents($path, $csv);
}
?>
