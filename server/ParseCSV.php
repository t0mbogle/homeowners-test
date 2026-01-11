<?php

final class ParseCSV
{
  public function parseCSV(): array
  {
    $csv = fopen("./examples.csv", "r", ",");

    $entries = [];

    while(! feof($csv)) {
      $line = fgets($csv);
      $entries[] = $line;
    }
    fclose($csv);


    $parsedData = [];

    foreach ($entries as $key => $entry) {
      if ($key !== array_key_last($entries) - 1) {
        $homeOwner = substr($entry, 0, strlen($entry) - 2);
        $parsedData[] = $homeOwner;
      }
      if ($key === array_key_last($entries) - 1) {
        $homeOwner = substr($entry, 0, strlen($entry) - 1);
        $parsedData[] = $homeOwner;
      }
    }

    return $parsedData;
  }
}