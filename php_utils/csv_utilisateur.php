<?php

function read_utilisateur_csv(string $path): array {
    if (!file_exists($path)) return [];

    $csv = [];
    $rows = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!$rows || count($rows) < 2) return [];

    $headers = str_getcsv($rows[0], ';');

    for ($i = 1; $i < count($rows); $i++) {
        $row = str_getcsv($rows[$i], ';');
        if (count($row) === count($headers)) {
            $csv[] = array_combine($headers, $row);
        }
    }

    return $csv;
}

function write_utilisateur_csv(array $csv, string $path) {
    if (empty($csv)) return;

    $headers = array_keys($csv[0]);
    $lines = [implode(';', $headers)];

    foreach ($csv as $row) {
        $line = [];
        foreach ($headers as $key) {
            $line[] = $row[$key] ?? '';
        }
        $lines[] = implode(';', $line);
    }

    file_put_contents($path, implode("\n", $lines));
}

function array_find_utilisateur_key(array $array, callable $callback) {
    foreach ($array as $key => $value) {
        if ($callback($value)) {
            return $key;
        }
    }
    return null;
}
