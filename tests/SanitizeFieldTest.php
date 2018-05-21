<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class SanitizeFieldTest extends AbstractTestCase
{
  /**
   * testSimpleExpressions
   */
  public function testSimpleExpressions()
  {
    $actual = Sortie::sanitizeField(' [ foo - > bar : baz | qux ] [  alpha  -  >  beta  :  gamma  |  delta  ]');

    $this->assertSame('[foo->bar:baz|qux] [alpha->beta:gamma|delta]', $actual);
  }

  /**
   * testBooleanExpressions
   */
  public function testBooleanExpressions()
  {
    $actual = Sortie::sanitizeField('[ if ( foo = bar ) { "TRUE" } else { "FALSE" } ] [  if  (  alpha  =  beta  )  {  "TRUE"  }  else  { "FALSE" } ]');

    $this->assertSame('[if(foo=bar){"TRUE"}else{"FALSE"}] [if(alpha=beta){"TRUE"}else{"FALSE"}]', $actual);
  }
}
