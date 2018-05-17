<?php
namespace Tests\Unit;

use ArgumentCountError;
use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyCleanTest extends AbstractTestCase
{
  /**
   * ---
   */
  public function testMissingInput()
  {
    $this->expectException(ArgumentCountError::class);

    $actual = Sortie::modifyClean();
  }

  /**
   * ---
   */
  public function testInvalidInputType()
  {
    foreach ($this->getNonStringTypes() as $type) {
      $this->assertSame('', Sortie::modifyClean($type));
    }
  }

  /**
   * ---
   */
  public function testDefault()
  {
    $inputs = [
      ' Foo Bar  Baz   ',
    ];

    foreach ($inputs as $input) {
      $this->assertSame('Foo Bar Baz', Sortie::modifyClean($input));
    }
  }
}
