<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyLimitTest extends AbstractTestCase
{
  const TEST_LIMIT  = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

  // Data Providers
  // ---------------------------------------------------------------------------

  /**
   * dataNoParams
   */
  public function dataNoParams()
  {
    return [
      [self::TEST_LIMIT, self::TEST_LIMIT],
    ];
  }

  /**
   * dataLimit
   */
  public function dataLimit()
  {
    return [
      ['1',  self::TEST_LIMIT, 'L...'],
      ['5',  self::TEST_LIMIT, 'Lorem...'],
      ['10', self::TEST_LIMIT, 'Lorem ipsu...'],
    ];
  }

  /**
   * dataLimitEnd
   */
  public function dataLimitEnd()
  {
    return [
      ['1',  '!',   self::TEST_LIMIT, 'L!'],
      ['5',  '!!',  self::TEST_LIMIT, 'Lorem!!'],
      ['10', '!!!', self::TEST_LIMIT, 'Lorem ipsu!!!'],
    ];
  }

  // Tests
  // ---------------------------------------------------------------------------

  /**
   * @dataProvider dataNoParams()
   */
  public function testNoParams($input, $expected)
  {
    $sortie = new Sortie('[foo->limit]');

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }

  /**
   * @dataProvider dataLimit()
   */
  public function testLimit($limit, $input, $expected)
  {
    $sortie = new Sortie("[foo->limit:{$limit}]");

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }

  /**
   * @dataProvider dataLimitEnd()
   */
  public function testLimitEnd($limit, $end, $input, $expected)
  {
    $sortie = new Sortie("[foo->limit:{$limit}:{$end}]");

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }
}
