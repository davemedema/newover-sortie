<?php
namespace Tests\Unit;

use ArgumentCountError;
use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyEmailTest extends AbstractTestCase
{
  /**
   * ---
   */
  public function testMissingInput()
  {
    $this->expectException(ArgumentCountError::class);

    $actual = Sortie::modifyEmail();
  }

  /**
   * ---
   */
  public function testInvalidInputType()
  {
    foreach ($this->getNonStringTypes() as $type) {
      $this->assertSame('', Sortie::modifyEmail($type));
    }
  }

  /**
   * ---
   */
  public function testInvalidEmail()
  {
    $this->assertSame('', Sortie::modifyEmail('foo'));
  }

  /**
   * ---
   */
  public function testSingleEmail()
  {
    $this->assertSame('foo@bar.com', Sortie::modifyEmail('FOO@bar.com'));
  }

  /**
   * ---
   */
  public function testMultipleEmail()
  {
    $this->assertSame('foo@bar.com', Sortie::modifyEmail('foo@bar.com,baz@qux.com'));
  }
}
