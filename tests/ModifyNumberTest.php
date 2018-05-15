<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyNumberTest extends AbstractTestCase
{
  /**
   * testDefault
   */
  public function testDefault()
  {
    $sortie = new Sortie('[foo->number]');

    $actual = $sortie->process(['foo' => '123.00']);

    $this->assertSame('123', $actual);
  }

  /**
   * testCurrency
   */
  public function testCurrency()
  {
    $sortie = new Sortie('[foo->number:2]');

    $actual = $sortie->process(['foo' => '123']);

    $this->assertSame('123.00', $actual);
  }

  /**
   * testDecimals
   */
  public function testDecimals()
  {
    $sortie = new Sortie('[foo->number:2]');

    $actual = $sortie->process(['foo' => '$123,456.99']);

    $this->assertSame('123,456.99', $actual);
  }
}
