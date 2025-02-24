<?php

if (!function_exists('dateToString')) {
    function dateToString(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::ATOM);
    }
}

if (!function_exists('stringToDate')) {
    function stringToDate(string $date): DateTimeImmutable
    {
        return new DateTimeImmutable($date);
    }
}

if (!function_exists('jsonEncode')) {
    function jsonEncode(array $values): string
    {
        return (string)json_encode($values);
    }
}

if (!function_exists('jsonDecode')) {
    function jsonDecode(string $json): array
    {
        $data = json_decode($json, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new RuntimeException('Unable to parse response body into JSON: ' . json_last_error());
        }

        return (array)$data;
    }
}
if (!function_exists('asBool')) {
    function asBool(bool|int|string $value)
    {
        $trueValues = ["true", "1", 1, "yes", "y", "on", true];
        if (is_string($value)) {
            $value = strtolower(trim($value));
        }
        if (in_array($value, $trueValues, true)) {
            return true;
        }
        return false;
    }
}

