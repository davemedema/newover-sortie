<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class RealWorldTest extends AbstractTestCase
{
  /**
   * test
   *
   * @group process
   */
  public function test()
  {
    // Escaped expression...
    $sortie = new Sortie('\[LDP\]');
    $actual = $sortie->process(['foo' => 'bar'], true);
    $this->assertSame('[LDP]', $actual);
  }
}
