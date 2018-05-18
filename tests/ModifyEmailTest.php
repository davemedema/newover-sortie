<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyEmailTest extends AbstractTestCase
{
  /**
   * data
   */
  public function data()
  {
    return [
      ['foo@bar.com', 'foo@bar.com'],
      ['FOO@BAR.COM', 'foo@bar.com'],
      ['foo@bar.com,baz@qux.com', 'foo@bar.com'],
      ['foo@bar.com , baz@qux.com', 'foo@bar.com'],
    ];
  }

  /**
   * @dataProvider data()
   */
  public function test($input, $expected)
  {
    $sortie = new Sortie('[foo->email]');

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }
}
