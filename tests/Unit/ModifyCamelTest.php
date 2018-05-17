<?php
namespace Tests\Unit;

use ArgumentCountError;
use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyCamelTest extends AbstractTestCase
{
  /**
   * ---
   */
  public function testMissingInput()
  {
    $this->expectException(ArgumentCountError::class);

    $actual = Sortie::modifyCamel();
  }

  /**
   * ---
   */
  public function testInvalidInputType()
  {
    foreach ($this->getNonStringTypes() as $type) {
      $this->assertSame('', Sortie::modifyCamel($type));
    }
  }

  /**
   * ---
   */
  public function testDefault()
  {
    $inputs = [
      'Foo Bar Baz',
    ];

    foreach ($inputs as $input) {
      $this->assertSame('fooBarBaz', Sortie::modifyCamel($input));
    }
  }
}
