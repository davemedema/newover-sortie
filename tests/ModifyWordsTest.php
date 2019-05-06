<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyWordsTest extends AbstractTestCase
{
  /**
   * @const string
   */
  const TEST_INPUT = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

  // Data Providers
  // ---------------------------------------------------------------------------

  /**
   * dataNoParams
   */
  public function dataNoParams()
  {
    return [
      [self::TEST_INPUT, self::TEST_INPUT],
    ];
  }

  /**
   * dataWords
   */
  public function dataWords()
  {
    return [
      ['0',   self::TEST_INPUT, ''],
      ['1',   self::TEST_INPUT, 'Lorem...'],
      ['3',   self::TEST_INPUT, 'Lorem ipsum dolor...'],
      ['100', self::TEST_INPUT, self::TEST_INPUT],
    ];
  }

  /**
   * dataWordsEnd
   */
  public function dataWordsEnd()
  {
    return [
      ['0',   '!',     self::TEST_INPUT, ''],
      ['1',   '!',     self::TEST_INPUT, 'Lorem!'],
      ['3',   '!',     self::TEST_INPUT, 'Lorem ipsum dolor!'],
      ['100', '!',     self::TEST_INPUT, self::TEST_INPUT],
      ['1',   '',      self::TEST_INPUT, 'Lorem'],
      ['1',   'false', self::TEST_INPUT, 'Lorem'],
    ];
  }

  // Tests
  // ---------------------------------------------------------------------------

  /**
   * @dataProvider dataNoParams()
   *
   * @group modify-words
   */
  public function testNoParams($input, $expected)
  {
    $sortie = new Sortie('[foo->words]');

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }

  /**
   * @dataProvider dataWords()
   *
   * @group modify-words
   */
  public function testWords($words, $input, $expected)
  {
    $sortie = new Sortie("[foo->words:{$words}]");

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }

  /**
   * @dataProvider dataWordsEnd()
   *
   * @group modify-words
   */
  public function testWordsEnd($words, $end, $input, $expected)
  {
    $sortie = new Sortie("[foo->words:{$words}:{$end}]");

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }
}
