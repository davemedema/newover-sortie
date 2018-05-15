<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyPhoneTest extends AbstractTestCase
{
  /**
   * testDefault
   */
  public function testDefault()
  {
    $sortie = new Sortie('[foo->phone]');

    // Invalid...
    $actual = $sortie->process(['foo' => '123']);

    $this->assertSame('', $actual);

    // 11 digits (default)...
    $actual = $sortie->process(['foo' => '12345678901']);

    $this->assertSame('12345678901', $actual);

    // 10 digits (default)...
    $actual = $sortie->process(['foo' => '1234567890']);

    $this->assertSame('11234567890', $actual);

    // 7 digits (default)...
    $actual = $sortie->process(['foo' => '1234567']);

    $this->assertSame('10001234567', $actual);
  }

  /**
   * testAreaCode
   */
  public function testAreaCode()
  {
    $sortie = new Sortie('[foo->phone:5:555]');

    $actual = $sortie->process(['foo' => '1234567']);

    $this->assertSame('55551234567', $actual);
  }

  /**
   * testCountryCode
   */
  public function testCountryCode()
  {
    $sortie = new Sortie('[foo->phone:5]');

    $actual = $sortie->process(['foo' => '1234567890']);

    $this->assertSame('51234567890', $actual);
  }
}
