<?php
namespace Tests\Unit;

use ArgumentCountError;
use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyKebabTest extends AbstractTestCase
{
  /**
   * ---
   */
  public function testMissingInput()
  {
    $this->expectException(ArgumentCountError::class);

    $actual = Sortie::modifyKebab();
  }

  /**
   * ---
   */
  public function testInvalidInputType()
  {
    foreach ($this->getNonStringTypes() as $type) {
      $this->assertSame('', Sortie::modifyKebab($type));
    }
  }

  /**
   * ---
   */
  public function testDefault()
  {
    $this->assertSame('foo-bar-baz', Sortie::modifyKebab('Foo Bar Baz'));
  }
}
