<?php
namespace Tests\Unit;

use ArgumentCountError;
use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyLimitTest extends AbstractTestCase
{
  /**
   * @var string
   */
  protected $input = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

  /**
   * ---
   */
  public function testMissingInput()
  {
    $this->expectException(ArgumentCountError::class);

    $actual = Sortie::modifyLimit();
  }

  /**
   * ---
   */
  public function testInvalidInputType()
  {
    foreach ($this->getNonStringTypes() as $type) {
      $this->assertSame('', Sortie::modifyLimit($type));
    }
  }

  /**
   * ---
   */
  public function testDefault()
  {
    $this->assertSame($this->input, Sortie::modifyLimit($this->input));
  }

  /**
   * ---
   */
  public function testLimitOnly()
  {
    $this->assertSame('Lor...', Sortie::modifyLimit($this->input, ['3']));
  }

  /**
   * ---
   */
  public function testLimitEnd()
  {
    $this->assertSame('Lor!', Sortie::modifyLimit($this->input, ['3', '!']));
  }
}
