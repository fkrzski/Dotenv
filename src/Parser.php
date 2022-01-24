<?php

namespace Dotenv;

use Dotenv\Exceptions\InvalidSyntaxException;

class Parser {
    /**
     * Parsing a given value
     * 
     * @param string $value
     * 
     * @return string
     */
    public static function parseValue($value) {
        if (empty($value)) {
            return $value;
        } elseif ($value[0] == '"') {
            return self::parseQuoted($value);
        } else {
            return self::parseUnquoted($value);
        }
    }

    /**
     * Parsing a value which starting from quotation mark
     * 
     * @param string $value
     * 
     * @throws \Dotenv\Exceptions\InvalidSyntaxException
     * 
     * @return string
     */
    protected static function parseQuoted($value) {
        if (substr_count($value, '"') == 2  && $value[strlen($value)-1] == '"') {
            $value = substr($value, 1, strlen($value)-2);
            return rtrim($value);
        } elseif (substr_count($value, '"') == 2  && $value[strlen($value)-1] != '"') {
            $value = substr($value, 1);
            $value = explode('"', $value);

            if (strpos($value[1], '#')) {
                return $value[0];
            } else {
                throw new InvalidSyntaxException("Only comments can be after closing quotation marks");
            }
        } else {
            throw new InvalidSyntaxException("Quoted variable must be closed");
        }
    }

    /**
     * Parsing a value without any quotation mark
     * 
     * @throws \Dotenv\Exceptions\InvalidSyntaxException
     * 
     * @return string
     */
    protected static function parseUnquoted($value) {
        if (strpos($value, '#')) {
            $value = substr($value, 0, strpos($value, '#'));
            $value = rtrim($value);
        }

        if (substr_count($value, ' ') > 0) {
            throw new InvalidSyntaxException("Unquoted values cannot have spaces");
        }
        return $value;
    }
}