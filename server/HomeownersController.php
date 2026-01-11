<?php

require_once 'ParseCSV.php';
require_once 'HomeownersFilter.php';
require_once 'NormalizeHomeowners.php';

final class HomeownersController
{
  public function __construct(
    public readonly ParseCSV $parser,
    public readonly HomeownersFilter $filter,
    public readonly NormalizeHomeowners $normalizer,
  ) {
  }

  public function __invoke()
  { 
    $parsedData = $this->parser->parseCSV();
    $validHomeowners = $this->filter->filter($parsedData);
    $homeowners = $this->normalizer->normalize($validHomeowners);

    print_r(json_encode($homeowners));
  }
}

// invoke
$controller = new HomeownersController(new ParseCSV, new HomeownersFilter, new NormalizeHomeowners);
$controller();