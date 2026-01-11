<?php

require_once 'NormalizeHomeowners.php';

class NormalizeHomeownersTest extends \PHPUnit\Framework\TestCase
{
  private NormalizeHomeowners $normalizer;

  protected function setUp(): void
  {
    $this->normalizer = new NormalizeHomeowners();
  }

  /** @dataProvider normalizeProvider */
  public function testNormalize(array $input, array $output, int $expectedHomeowners) {
    $response = $this->normalizer->normalize($input);
    $this->assertSame(json_encode($response), json_encode($output));
    $this->assertSame(count($response), $expectedHomeowners);
  }

  public static function normalizeProvider(): iterable
  {
    yield 'one entry' => [
      'input' => ['Mr John Smith'],
      'output' => [
        [
          'title' => 'Mr',
          'first_name' => 'John',
          'last_name' => 'Smith',
          'initial' => null,
        ]
      ],
      'expectedHomeowners' => 1
    ];

    yield 'multiple entries, including single homeowners and multiple homeowners per entry' => [
      'input' => ['Mr John Smith', 'Mr Tom Staff and Mr John Doe', 'Dr & Mrs Joe Bloggs'],
      'output' => [
        [
          'title' => 'Mr',
          'first_name' => 'John',
          'last_name' => 'Smith',
          'initial' => null,
        ],
        [
          'title' => 'Mr',
          'first_name' => 'Tom',
          'last_name' => 'Staff',
          'initial' => null,
        ],
        [
          'title' => 'Mr',
          'first_name' => 'John',
          'last_name' => 'Doe',
          'initial' => null,
        ],
        [
          'title' => 'Dr',
          'first_name' => null,
          'last_name' => 'Bloggs',
          'initial' => null,
        ],
        [
          'title' => 'Mrs',
          'first_name' => 'Joe',
          'last_name' => 'Bloggs',
          'initial' => null,
        ],
      ],
      'expectedHomeowners' => 5
    ];
  }
    
  /** @dataProvider multipleHomeownersProvider */
  public function testFormatMultipleHomeownersEntry(string $input, array $output)
  {
    $response = $this->normalizer->formatMultipleHomeownersEntry($input);
    $this->assertSame($response, $output);
  }

  public static function multipleHomeownersProvider(): iterable
  {
    yield 'title, title and surname' => [
      'input' => 'Mr and Mrs Smith',
      'output' => [['Mr', 'Smith'], ['Mrs','Smith']],
    ];

    yield 'all fields apart from initials' => [
      'input' => 'Mr Tom Staff and Mr John Doe',
      'output' => [['Mr', 'Tom', 'Staff'], ['Mr','John', 'Doe']],
    ];

    yield 'title, all fields, ampersand' => [
      'input' => 'Dr & Mrs Joe Bloggs',
      'output' => [['Dr', 'Bloggs'], ['Mrs','Joe', 'Bloggs']],
    ];
  }
}
