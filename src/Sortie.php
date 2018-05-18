<?php
namespace Sortie;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Str;

class Sortie
{
  /**
   * The processed expressions.
   *
   * @var array
   */
  protected $expressions = [];

  /**
   * The raw field.
   *
   * @var string
   */
  protected $field = '';

  /**
   * The processed properties.
   *
   * @var array
   */
  protected $properties = [];

  /**
   * Create a new Sortie instance.
   *
   * @param string $field
   */
  public function __construct($field)
  {
    $this->setField($field);
  }

  // Public Methods
  // ---------------------------------------------------------------------------

  /**
   * getExpressions
   *
   * @return array
   */
  public function getExpressions()
  {
    return $this->expressions;
  }

  /**
   * getField
   *
   * @return string
   */
  public function getField()
  {
    return $this->field;
  }

  /**
   * getProperties
   *
   * @return array
   */
  public function getProperties()
  {
    return $this->properties;
  }

  /**
   * process
   *
   * @param array $data
   *
   * @return string
   */
  public function process($data)
  {
    $data      = $this->sanitizeData($data);
    $processed = $this->field;

    foreach ($this->expressions as $expression) {
      $replace = '';

      switch ($expression['type']) {
      case 'boolean':
        $replace = $this->replaceBoolean($expression, $data);
        break;
      case 'simple':
        $replace = $this->replaceSimple($expression, $data);
        break;
      }

      $search    = sprintf('[%s]', $expression['expression']);
      $processed = str_replace($search, $replace, $processed);
    }

    $processed = $this->modifyClean($processed);

    return $processed;
  }

  /**
   * setField
   *
   * @param string $field
   *
   * @return void
   */
  public function setField($field)
  {
    $this->field = static::sanitizeField($field);

    $this->hydrate();
  }

  // Protected Methods
  // ---------------------------------------------------------------------------

  /**
   * Processes and returns the options in an expression and populates
   * `$this->properties` along the way.
   *
   * @param string $expression
   *
   * @return array
   */
  protected function getOptions($expression)
  {
    $options    = [];
    $rawOptions = explode('|', $expression);

    foreach ($rawOptions as $rawOption) {
      $optionParts = explode('->', $rawOption);
      $property    = array_shift($optionParts);

      $options[] = [
        'property'  => $property,
        'modifiers' => $optionParts
      ];

      $this->properties[] = $property;
    }

    return $options;
  }

  /**
   * hydrate
   *
   * @return void
   */
  protected function hydrate()
  {
    // Reset the hyrated expressions and properties first in case the field is
    // empty or invalid.
    $this->expressions = [];
    $this->properties  = [];

    if (!$this->field) {
      return;
    }

    preg_match_all('/\[([^\]]+)\]/u', $this->field, $matches);

    if (empty($matches[1])) {
      return;
    }

    foreach ($matches[1] as $expression) {
      $expression = static::sanitizeExpression($expression);

      if (preg_match('/^if\s*\(([^\)]+)\)\s*{([^}]*)}\s*else\s*{([^}]*)}$/iu', $expression, $matches)) {
        $this->expressions[] = [
          'expression' => $expression,
          'parts'      => array_slice($matches, 1),
          'type'       => 'boolean',
        ];
      } else {
        $this->expressions[] = [
          'expression' => $expression,
          'options'    => $this->getOptions($expression),
          'type'       => 'simple',
        ];
      }
    }
  }

  /**
   * Modifies an input.
   *
   * @param string $input
   * @param string $modifier
   *
   * @throws Exception if the modifier is not whitelisted.
   *
   * @return string
   */
  protected function modify(string $input, string $modifier): string
  {
    $parts = explode(':', $modifier);

    switch ($parts[0]) {
    case 'camel':
      return $this->modifyCamel($input);
    case 'clean':
      return $this->modifyClean($input);
    case 'date':
      return $this->modifyDate($input, array_slice($parts, 1));
    case 'email':
      return $this->modifyEmail($input);
    case 'kebab':
      return $this->modifyKebab($input);
    case 'limit':
      return $this->modifyLimit($input, array_slice($parts, 1));
    default:
      throw new Exception(sprintf('%s() expects modifier to be whitelisted.',
        __METHOD__
      ));
    }
  }

  /**
   * modifyCamel
   *
   * @param string $input
   *
   * @return string
   */
  protected function modifyCamel(string $input): string
  {
    return Str::camel($input);
  }

  /**
   * modifyClean
   *
   * @param string $input
   *
   * @return string
   */
  protected function modifyClean(string $input): string
  {
    return trim(preg_replace('/\s+/', ' ', $input));
  }

  /**
   * modifyDate
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyDate(string $input, array $params): string
  {
    $carbon = Carbon::parse($input);

    if (count($params) < 1) {
      return $carbon->format('m/d/Y');
    }

    $format = implode(':', $params);
    $format = trim($format, '"');

    switch ($format) {
    case 'ATOM':
      $format = DateTime::ATOM;
      break;
    case 'ISO8601':
      $format = DateTime::ATOM;
      break;
    case 'RFC3339':
      $format = DateTime::RFC3339;
      break;
    case 'datetime':
      $format = 'Y-m-d H:i:s';
      break;
    }

    return $carbon->format($format);
  }

  /**
   * modifyEmail
   *
   * @param string $input
   *
   * @return string
   */
  protected function modifyEmail(string $input): string
  {
    $emails = explode(',', $input);

    $email = trim($emails[0]);

    return filter_var($email, FILTER_VALIDATE_EMAIL) ? Str::lower($email) : '';
  }

  /**
   * modifyKebab
   *
   * @param string $input
   *
   * @return string
   */
  protected function modifyKebab(string $input): string
  {
    return Str::kebab($input);
  }

  /**
   * modifyLimit
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyLimit(string $input, array $params): string
  {
    $limit = isset($params[0]) ? (int)$params[0] : 100;
    $end   = isset($params[1]) ? $params[1] : '...';

    return Str::limit($input, $limit, $end);
  }

  /**
   * modifyLower
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyLower($input, $params = [])
  {
    if (isset($params[0])) {
      $ignore = explode(',', $params[0]);

      if (in_array($input, $ignore)) {
        return $input;
      }
    }

    return Str::lower($input);
  }

  /**
   * modifyException
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyException($input, $params)
  {
    throw new Exception('Exception for testing purposes.');
  }

  /**
   * modifyNumber
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyNumber($input, $params)
  {
    $decimals = isset($params[0]) ? (int)$params[0] : 0;

    // 2017-11-28: The number modifier needs to be able to handle currencies
    // and their symbols. Therefor, we need to strip out any character that
    // might cause an issue when casting `$input` to a float.
    $number = preg_replace('/[^\d|\.]/iu', '', $input);
    $number = (float)$number;

    return number_format($number, $decimals);
  }

  /**
   * modifyPhone
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyPhone($input, $params)
  {
    $phone = preg_replace('/[^\d]/', '', $input);

    if (strlen($phone) === 11) {
      return $phone;
    }

    $countryCode = isset($params[0]) ? $params[0] : '1';
    $areaCode    = isset($params[1]) ? $params[1] : '000';

    if (strlen($phone) === 10) {
      return sprintf('%s%s', $countryCode, $phone);
    }

    if (strlen($phone) === 7) {
      return sprintf('%s%s%s', $countryCode, $areaCode, $phone);
    }

    return '';
  }

  /**
   * modifyPick
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyPick($input, $params)
  {
    if (count($params) < 2) {
      return $input;
    }

    $delimiter = trim($params[0]);

    switch ($delimiter) {
    case '%SP%':
      $delimiter = ' ';
      break;
    }

    $inputs = explode($delimiter, $input);

    $index = intval($params[1]);

    if ($index < 0) {
      $index = (count($inputs) + $index);
    }

    return isset($inputs[$index]) ? $inputs[$index] : $input;
  }

  /**
   * modifyPiped
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyPiped($input, $params)
  {
    if (count($params) < 1) {
      return $input;
    }

    $index = intval($params[0]);

    return $this->modifyPick($input, ['|', $index]);
  }

  /**
   * modifyPlural
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyPlural($input, $params)
  {
    return Str::plural($input);
  }

  /**
   * modifyPostal
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyPostal($input, $params)
  {
    $postal = trim($input);

    $country = isset($params[0]) ? Str::upper($params[0]) : 'US';

    switch ($country) {
    case 'CA':
      $isValid = (bool)preg_match('/^([ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ])([\ ])?(\d[ABCEGHJKLMNPRSTVWXYZ]\d)$/iu', $postal);
      break;
    case 'US':
      $isValid = (bool)preg_match('/^([0-9]{5})(-[0-9]{4})?$/iu', $postal);
      break;
    default:
      $isValid = false;
      break;
    }

    if (!$isValid) {
      return '';
    }

    // DEPRECATED 2017-11-17: If a postal code gets through the validation
    // we can just pass it along. No need to sanitize further.
    // $postal = preg_replace('/[^\d]/', '', $input);

    return $postal;
  }

  /**
   * modifyPrice
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyPrice($input, $params)
  {
    return $this->modifyNumber($input, ['2']);
  }

  /**
   * modifyReplace
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyReplace($input, $params)
  {
    if (!isset($params[0]) || !isset($params[1])) {
      return $input;
    }

    $pattern = trim($params[0], "'");
    $pattern = str_replace('%LB%', '[', $pattern);
    $pattern = str_replace('%RB%', ']', $pattern);

    $replacement = trim($params[1], "'");

    return preg_replace($pattern, $replacement, $input);
  }

  /**
   * modifySingular
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifySingular($input, $params)
  {
    return Str::singular($input);
  }

  /**
   * modifySlug
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifySlug($input, $params)
  {
    return Str::slug($input);
  }

  /**
   * modifySnake
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifySnake($input, $params)
  {
    return Str::snake($input);
  }

  /**
   * modifyStudly
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyStudly($input, $params)
  {
    return Str::studly($input);
  }

  /**
   * modifySubstr
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifySubstr($input, $params)
  {
    if (count($params) < 1) {
      return $input;
    }

    $start  = isset($params[0]) ? (int)$params[0] : 0;
    $length = isset($params[1]) ? (int)$params[1] : null;

    return Str::substr($input, $start, $length);
  }

  /**
   * modifyTitle
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyTitle($input, $params)
  {
    if (isset($params[0])) {
      $ignore = explode(',', $params[0]);

      if (in_array($input, $ignore)) {
        return $input;
      }
    }

    return Str::title($input);
  }

  /**
   * modifyTrim
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyTrim($input, $params)
  {
    return trim($input);
  }

  /**
   * modifyUcfirst
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyUcfirst($input, $params)
  {
    return Str::ucfirst($input);
  }

  /**
   * modifyUpper
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyUpper($input, $params)
  {
    if (isset($params[0])) {
      $ignore = explode(',', $params[0]);

      if (in_array($input, $ignore)) {
        return $input;
      }
    }

    return Str::upper($input);
  }

  /**
   * modifyUrl
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyUrl($input, $params)
  {
    $url = urldecode($input);
    $url = trim($url);
    $url = trim($url, '/');

    return $url;
  }

  /**
   * modifyUrldecode
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyUrldecode($input, $params)
  {
    return urldecode($input);
  }

  /**
   * modifyWords
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyWords($input, $params)
  {
    if (count($params) < 1) {
      return $input;
    }

    $words = isset($params[0]) ? (int)$params[0] : 100;
    $end   = isset($params[1]) ? $params[1] : '...';

    return Str::words($input, $words, $end);
  }

  /**
   * modifyYear
   *
   * @param string $input
   * @param array  $params
   *
   * @return string
   */
  protected function modifyYear($input, $params)
  {
    return (string)(int)$input;
  }

  /**
   * Returns human-readable information about a variable.
   *
   * @param mixed $variable
   *
   * @return string
   */
  protected function getReadableVariable($variable): string
  {
    return is_string($variable) ? $variable : json_encode($variable);
  }

  /**
   * replaceBoolean
   *
   * @param array $expression
   * @param array $data
   *
   * @return string
   */
  protected function replaceBoolean($expression, $data)
  {
    $parts = $expression['parts'];

    $condition  = $expression['parts'][0];
    $conditions = explode('=', $condition);

    if (empty($conditions[0]) || empty($conditions[1])) {
      // TODO: Log this to improve edge cases.
      return '';
    }

    $replace1 = $this->replaceSimple([
      'expression' => $conditions[0],
      'options'    => $this->getOptions($conditions[0]),
      'type'       => 'simple',
    ], $data);

    $replace2 = $this->replaceSimple([
      'expression' => $conditions[1],
      'options'    => $this->getOptions($conditions[1]),
      'type'       => 'simple',
    ], $data);

    $replace3 = $this->replaceSimple([
      'expression' => $parts[1],
      'options'    => $this->getOptions($parts[1]),
      'type'       => 'simple',
    ], $data);

    $replace4 = $this->replaceSimple([
      'expression' => $parts[2],
      'options'    => $this->getOptions($parts[2]),
      'type'       => 'simple',
    ], $data);

    return ($replace1 === $replace2) ? $replace3 : $replace4;
  }

  /**
   * replaceSimple
   *
   * @param array $expression
   * @param array $data
   *
   * @return string
   */
  protected function replaceSimple($expression, $data)
  {
    $replace = '';

    foreach ($expression['options'] as $option) {
      if ($replace) {
        break;
      }

      $property = $option['property'];

      if (preg_match('/^"(.+)"$/u', $property, $matches)) {
        $replace = $matches[1];
      } else {
        $property = Str::lower(trim($property));
        $replace  = $data[$property] ?? '';
      }

      foreach ($option['modifiers'] as $modifier) {
        $replace = $this->modify($replace, $modifier);
      }
    }

    return $replace;
  }

  // Static Methods
  // ---------------------------------------------------------------------------

  /**
   * Sanitizes raw data.
   *
   * @param array $data
   *
   * @return array
   */
  public static function sanitizeData($data)
  {
    $sanitized = [];

    foreach ($data as $key => $value) {
      $sanitized[Str::lower(trim($key))] = $value;
    }

    return $sanitized;
  }

  /**
   * Sanitizes a raw expression.
   *
   * @param string $expression
   *
   * @return string
   */
  public static function sanitizeExpression($expression)
  {
    $sanitized = trim($expression);

    return $sanitized;
  }

  /**
   * Sanitizes a raw field.
   *
   * @param string $field
   *
   * @return string
   */
  public static function sanitizeField($field)
  {
    $sanitized = trim($field);

    // Simple...
    $sanitized = preg_replace('/\[\s*/u',       '[',  $sanitized); // Remove spaces after "[".
    $sanitized = preg_replace('/\s*\]/u',       ']',  $sanitized); // Remove spaces before "]".
    $sanitized = preg_replace('/\s*-\s*>\s*/u', '->', $sanitized); // Remove spaces in and around "->".
    $sanitized = preg_replace('/\s*\|\s*/u',    '|',  $sanitized); // Remove spaces around "|".
    $sanitized = preg_replace('/\s*:\s*/u',     ':',  $sanitized); // Remove spaces around ":".

    // Boolean...
    $sanitized = preg_replace('/\s*\(\s*/u', '(', $sanitized); // Remove spaces around "(".
    $sanitized = preg_replace('/\s*\)\s*/u', ')', $sanitized); // Remove spaces around ")".
    $sanitized = preg_replace('/\s*=\s*/u',  '=', $sanitized); // Remove spaces around "=".
    $sanitized = preg_replace('/\s*{\s*/u',  '{', $sanitized); // Remove spaces around "{".
    $sanitized = preg_replace('/\s*}\s*/u',  '}', $sanitized); // Remove spaces around "}".

    return $sanitized;
  }
}
