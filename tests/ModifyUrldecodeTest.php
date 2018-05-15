<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyUrldecodeTest extends AbstractTestCase
{
  /**
   * test
   */
  public function test()
  {
    $sortie = new Sortie('[foo->urldecode]');

    $actual = $sortie->process(['foo' => 'http://foo.com/%20bar%20/']);

    $this->assertSame('http://foo.com/ bar /', $actual);
  }
}
