<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyCalcTest extends AbstractTestCase
{
  /**
   * test
   *
   * @group modify-calc
   */
  public function test()
  {
    // Addition...
    $sortie = new Sortie('[add(foo,bar)]');

    $actual = $sortie->process([
      'foo' => '5',
      'bar' => '2',
    ]);

    $this->assertSame('7', $actual);

    $sortie = new Sortie('[add(foo->replace:\'/\D*/\':\'\',bar)]');

    $actual = $sortie->process([
      'foo' => '$5',
      'bar' => '2',
    ]);

    $this->assertSame('7', $actual);

    // Division...
    $sortie = new Sortie('[div(foo,bar)]');

    $actual = $sortie->process([
      'foo' => '6',
      'bar' => '2',
    ]);

    $this->assertSame('3', $actual);

    // Multiplication...
    $sortie = new Sortie('[mul(foo,bar)]');

    $actual = $sortie->process([
      'foo' => '5',
      'bar' => '2',
    ]);

    $this->assertSame('10', $actual);

    // Subtraction...
    $sortie = new Sortie('[sub(foo,bar)]');

    $actual = $sortie->process([
      'foo' => '5',
      'bar' => '2',
    ]);

    $this->assertSame('3', $actual);
  }
}
