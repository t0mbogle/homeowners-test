<?php

final class HomeownersFilter
{
  public function filter(array $homeOwners): array
  {
    return array_filter($homeOwners, function (string $entry) {
      $explodedEntry = explode(' ', $entry);

      if (count($explodedEntry) < 2) {
        return false;
      }

      return true;
      }
    );
  }
}