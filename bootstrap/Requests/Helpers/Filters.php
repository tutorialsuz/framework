<?php

namespace Bootstrap\Requests\Helpers;

class Filters
{
    /*
     * Validates integer values
     * */
    public const VALIDATE_INT = 'integer';

    /*
     * Validates email
     * */
    public const VALIDATE_EMAIL = 'email';

    /*
     * Validates url
     * */
    public const VALIDATE_URL = 'url';

    /*
     * Validates float numbers
     * */
    public const VALIDATE_FLOAT = 'float';

    /*
     * Validates IP address
     * */
    public const VALIDATE_IP = 'ip';

    /*
     * Validates REGEX
     * */
    public const VALIDATE_REGEX = 'regex';

    /*
     * Validates required input
     * */
    public const VALIDATE_REQUIRED = 'required';

    /**
     * Returns list of filters
     * @return array
     */
    public static function all(): array
    {
        return [
          self::VALIDATE_EMAIL => FILTER_VALIDATE_EMAIL,
          self::VALIDATE_FLOAT => FILTER_VALIDATE_FLOAT,
          self::VALIDATE_INT => FILTER_VALIDATE_INT,
          self::VALIDATE_REGEX => FILTER_VALIDATE_REGEXP,
          self::VALIDATE_IP => FILTER_VALIDATE_IP,
          self::VALIDATE_URL => FILTER_VALIDATE_URL,
          self::VALIDATE_REQUIRED => [
              'options' => 'required'
          ]
        ];
    }

    public static function get(string $key)
    {
        return static::all()[$key];
    }
}