<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyYearTest extends AbstractTestCase
{
  /**
   * test
   */
  public function test()
  {
    $sortie = new Sortie('[foo->year]');

    $actual = $sortie->process(['foo' => '20.0']);

    $this->assertSame('20', $actual);
  }
}
