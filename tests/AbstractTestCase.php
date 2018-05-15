<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Sortie\Sortie;

abstract class AbstractTestCase extends TestCase
{
  /**
   * setUp
   */
  protected function setUp()
  {
  }

  /**
   * tearDown
   */
  protected function tearDown()
  {
  }

  /**
   * assertSortie
   *
   * @param mixed $actual
   */
  protected function assertSortie($actual)
  {
    $this->assertInstanceOf(Sortie::class, $actual);
  }
}
