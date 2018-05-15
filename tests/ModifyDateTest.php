<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyDateTest extends AbstractTestCase
{
  /**
   * testDefaultFormat
   */
  public function testDefaultFormat()
  {
    $sortie = new Sortie('[foo->date]');

    $actual = $sortie->process(['foo' => '2010-01-01 00:00:00']);

    $this->assertSame('01/01/2010', $actual);
  }

  /**
   * testConstantFormat
   */
  public function testConstantFormat()
  {
    $sortie = new Sortie('[foo->date:ATOM]');

    $actual = $sortie->process(['foo' => '2010-01-01 00:00:00']);

    $this->assertSame('2010-01-01T00:00:00+00:00', $actual);
  }

  /**
   * testCustomFormat
   */
  public function testCustomFormat()
  {
    $sortie = new Sortie("[foo->date:'n/j/Y @ g:i a']");

    $actual = $sortie->process(['foo' => '2010-01-01 00:00:00']);

    $this->assertSame('1/1/2010 @ 12:00 am', $actual);
  }

  /**
   * testQuickFormat
   */
  public function testQuickFormat()
  {
    $sortie = new Sortie("[foo->date:datetime]");

    $actual = $sortie->process(['foo' => '2010-01-01T00:00:00+00:00']);

    $this->assertSame('2010-01-01 00:00:00', $actual);
  }
}
