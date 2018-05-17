<?php
namespace Tests\Unit;

use ArgumentCountError;
use Sortie\Sortie;
use Tests\AbstractTestCase;

class SanitizeFieldTest extends AbstractTestCase
{
  /**
   * ---
   */
  public function testMissingField()
  {
    $this->expectException(ArgumentCountError::class);

    $actual = Sortie::sanitizeField();
  }

  /**
   * ---
   */
  public function testInvalidField()
  {
    foreach ($this->getNonStringTypes() as $type) {
      $this->assertSame('', Sortie::sanitizeField($type));
    }
  }

  /**
   * ---
   */
  public function testSimpleExpressions()
  {
    $actual = Sortie::sanitizeField(' [ foo - > bar : baz | qux ] [  alpha  -  >  beta  :  gamma  |  delta  ]');

    $this->assertSame('[foo->bar:baz|qux] [alpha->beta:gamma|delta]', $actual);
  }

  /**
   * ---
   */
  public function testBooleanExpressions()
  {
    $actual = Sortie::sanitizeField('[ if ( foo = bar ) { "TRUE" } else { "FALSE" } ] [  if  (  alpha  =  beta  )  {  "TRUE"  }  else  { "FALSE" } ]');

    $this->assertSame('[if(foo=bar){"TRUE"}else{"FALSE"}] [if(alpha=beta){"TRUE"}else{"FALSE"}]', $actual);
  }
}
