<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyUrlTest extends AbstractTestCase
{
  /**
   * test
   */
  public function test()
  {
    $sortie = new Sortie('[foo->url]');

    $actual = $sortie->process(['foo' => ' http://foo.com/%20 ']);

    $this->assertSame('http://foo.com', $actual);
  }
}
