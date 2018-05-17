<?php
namespace Tests\Unit;

use ArgumentCountError;
use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyLowerTest extends AbstractTestCase
{
  /**
   * ---
   */
  public function testMissingInput()
  {
    $this->expectException(ArgumentCountError::class);

    $actual = Sortie::modifyLower();
  }

  /**
   * ---
   */
  public function testInvalidInputType()
  {
    foreach ($this->getNonStringTypes() as $type) {
      $this->assertSame('', Sortie::modifyLower($type));
    }
  }

  /**
   * ---
   */
  public function testDefault()
  {
    $this->assertSame('foo', Sortie::modifyLower('FOO'));
  }

  /**
   * ---
   */
  public function testIgnore()
  {
    $this->assertSame('BAZ', Sortie::modifyLower('BAZ', ['FOO,BAR,BAZ']));
  }
}
