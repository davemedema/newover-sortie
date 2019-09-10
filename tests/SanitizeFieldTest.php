<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class SanitizeFieldTest extends AbstractTestCase
{
  public function data()
  {
    return [
      'spaces' => [
        ' [ foo - > bar : baz | qux ] [  alpha  -  >  beta  :  gamma  |  delta  ]',
        '[foo->bar:baz|qux] [alpha->beta:gamma|delta]'
      ],
      'boolean' => [
        '[ if ( foo = bar ) { "TRUE" } else { "FALSE" } ] [  if  (  alpha  =  beta  )  {  "TRUE"  }  else  { "FALSE" } ]',
        '[if(foo=bar){"TRUE"}else{"FALSE"}] [if(alpha=beta){"TRUE"}else{"FALSE"}]'
      ],
      'raw literals' => [
        '[Foo (Bar) Baz->alpha]',
        '[Foo(Bar)Baz->alpha]'
      ],
      'escaped literals' => [
        '[Foo %FLP%Bar%FRP% Baz->alpha]',
        '[Foo (Bar) Baz->alpha]'
      ],
    ];
  }

  /**
   * @dataProvider data
   */
  public function test($field, $expected)
  {
    $actual = Sortie::sanitizeField($field);

    $this->assertSame($expected, $actual);
  }
}
