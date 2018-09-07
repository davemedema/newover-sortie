<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyPriceTest extends AbstractTestCase
{
  /**
   * test
   */
  public function test()
  {
    $sortie = new Sortie('[foo->price]');

    // Integer...
    $actual = $sortie->process(['foo' => '123']);

    $this->assertSame('123.00', $actual);

    // String with currency symbols...
    $actual = $sortie->process(['foo' => '$123,456']);

    $this->assertSame('123,456.00', $actual);

    // Options with a leading zero result...
    $sortie = new Sortie('[foo->price|bar->price]');

    $actual = $sortie->process([
      'foo' => '0',
      'bar' => '$123,456'
    ]);

    $this->assertSame('123,456.00', $actual);
  }
}
