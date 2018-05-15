<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyEmailTest extends AbstractTestCase
{
  /**
   * testDefault
   */
  public function testDefault()
  {
    $sortie = new Sortie('[foo->email]');

    // Invalid...
    $actual = $sortie->process(['foo' => 'FOO']);

    $this->assertSame('', $actual);

    // Valid...
    $actual = $sortie->process(['foo' => 'FOO@bar.com']);

    $this->assertSame('foo@bar.com', $actual);

    // Multiple...
    $actual = $sortie->process(['foo' => 'foo@foo.com,bar@bar.com']);

    $this->assertSame('foo@foo.com', $actual);
  }
}
