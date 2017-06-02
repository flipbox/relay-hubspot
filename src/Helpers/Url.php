<?php

namespace Flipbox\Relay\HubSpot\Helpers;

class Url
{

    /**
     * Generate a query string.
     *
     * @param  array $params
     * @param  int $encoding
     * @return string
     */
    public static function queryString(array $params = [], int $encoding = PHP_QUERY_RFC3986): string
    {
        if (empty($params)) {
            return '';
        }

        $query = '';
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $query .= static::batchQueryString($key, $value, $encoding);
            } elseif (!empty($value)) {
                $query .= '&' . static::encode($key, $encoding) . '=' . static::encode($value, $encoding);
            }
        }

        return $query ?: '';
    }

    /**
     * Generate a query string for batch requests.
     *
     * @param  string $key The name of the query variable.
     * @param  array $items An array of item values for the variable.
     * @param  int $encoding
     * @return string
     */
    public static function batchQueryString(string $key, array $items, int $encoding = PHP_QUERY_RFC3986): string
    {
        return array_reduce($items, function ($query, $item) use ($key, $encoding) {
            return $query . "&" . static::encode($key, $encoding) . '=' . static::encode($item, $encoding);
        }, '');
    }

    /**
     * Url encode a string.
     *
     * @param  string $value
     * @param  int $encoding
     * @return string
     */
    public static function encode(string $value, int $encoding = PHP_QUERY_RFC3986): string
    {
        switch ($encoding) {
            case false:
                return $value;
            case PHP_QUERY_RFC3986:
                return rawurlencode($value);
            case PHP_QUERY_RFC1738:
                return urlencode($value);
            default:
                throw new \InvalidArgumentException('Invalid type');
        }
    }
}
