<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyLimitTest extends AbstractTestCase
{
  /**
   * test
   *
   * @group modify-limit
   */
  public function test()
  {
    // Default...
    $sortie = new Sortie('[foo->limit]');

    $actual = $sortie->process(['foo' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.']);

    $this->assertSame('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', $actual);

    // No end...
    $sortie = new Sortie('[foo->limit:3]');

    $actual = $sortie->process(['foo' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.']);

    $this->assertSame('Lor...', $actual);

    // With end...
    $sortie = new Sortie('[foo->limit:3:!]');

    $actual = $sortie->process(['foo' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.']);

    $this->assertSame('Lor!', $actual);
  }
}
