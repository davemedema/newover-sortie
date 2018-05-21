<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyWordsTest extends AbstractTestCase
{
  /**
   * test
   *
   * @group modify-words
   */
  public function test()
  {
    // No parameters...
    $sortie = new Sortie('[foo->words]');

    $actual = $sortie->process(['foo' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.']);

    $this->assertSame('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', $actual);

    // No end...
    $sortie = new Sortie('[foo->words:3]');

    $actual = $sortie->process(['foo' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.']);

    $this->assertSame('Lorem ipsum dolor...', $actual);

    // With end...
    $sortie = new Sortie('[foo->words:3:!]');

    $actual = $sortie->process(['foo' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.']);

    $this->assertSame('Lorem ipsum dolor!', $actual);
  }
}
