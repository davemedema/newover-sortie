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
  protected function assertReturnsEmptyStringWhen($actual)
  {
    $this->assertInstanceOf(Sortie::class, $actual);
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

  /**
   * getNonArrayTypes
   *
   * @return array
   */
  protected function getNonArrayTypes()
  {
    return [
      true,       // boolean
      123.45,     // float
      123,        // integer
      null,       // null
      (object)[], // object
      'abc',      // string
    ];
  }

  /**
   * getNonStringTypes
   *
   * @return array
   */
  protected function getNonStringTypes()
  {
    return [
      [],         // array
      true,       // boolean
      123.45,     // float
      123,        // integer
      null,       // null
      (object)[], // object
    ];
  }
}
