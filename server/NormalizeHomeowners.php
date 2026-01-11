<?php

final class NormalizeHomeowners
{
  public function normalize(array $homeOwners)
  {
    $normalizedHomeowners = [];

    foreach ($homeOwners as $key => $homeOwner) {
      // handle single homeowner per line
      if (!str_contains($homeOwner, '&') && !str_contains($homeOwner, 'and')) {
        $split = explode(' ', $homeOwner);
        $useInitial = strlen($split[1]) === 1 || substr($split[1], -1) === '.';

        $normalizedHomeowners[] = (object) [
          'title' => $split[0],
          'first_name' => $useInitial ? null : $split[1],
          'last_name' => $split[2],
          'initial' => $useInitial ? $split[1] : null
        ];
      } else {
        // handle multiple homeowners per line
        $formattedHomeowners = $this->formatMultipleHomeownersEntry($homeOwner);

        foreach ($formattedHomeowners as $formattedHomeowner) {
          $normalizedHomeowners[] = (object) [
            'title' => $formattedHomeowner[0],
            'first_name' => count($formattedHomeowner) === 3 ? $formattedHomeowner[1] : null,
            'last_name' => count($formattedHomeowner) === 3 ? $formattedHomeowner[2] : $formattedHomeowner[1],
            'initial' => null
          ];
        }
      }
    }

    return $normalizedHomeowners;
  }

  public function formatMultipleHomeownersEntry(string $homeOwner): array
  {
    $explodedEntry = explode(' ', $homeOwner);
    
    $intersect = 0;
    foreach ($explodedEntry as $key => $entry) {
      if ($entry === 'and' || $entry === '&') {
        $intersect = $key;
      }
    }
        
    $firstEntry = array_slice($explodedEntry, 0, $intersect);
    $secondEntry = array_slice($explodedEntry, $intersect + 1);

    if (count($firstEntry) === 1) {
      $firstEntry[] = end($secondEntry);
    }

    return [$firstEntry, $secondEntry];
  }
}