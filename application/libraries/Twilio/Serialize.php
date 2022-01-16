<?php

declare(strict_types=1);

namespace Twilio;

class Serialize
{
    public static function prefixedCollapsibleMap($map, string $prefix): array
    {
        if (null === $map || Values::NONE === $map) {
            return [];
        }

        $flattened = self::flatten($map);
        $result = [];
        foreach ($flattened as $key => $value) {
            $result[$prefix.'.'.$key] = $value;
        }

        return $result;
    }

    public static function iso8601Date($dateTime): string
    {
        if (null === $dateTime || Values::NONE === $dateTime) {
            return Values::NONE;
        }

        if (\is_string($dateTime)) {
            return $dateTime;
        }

        $utcDate = clone $dateTime;
        $utcDate->setTimezone(new \DateTimeZone('UTC'));

        return $utcDate->format('Y-m-d');
    }

    public static function iso8601DateTime($dateTime): string
    {
        if (null === $dateTime || Values::NONE === $dateTime) {
            return Values::NONE;
        }

        if (\is_string($dateTime)) {
            return $dateTime;
        }

        $utcDate = clone $dateTime;
        $utcDate->setTimezone(new \DateTimeZone('UTC'));

        return $utcDate->format('Y-m-d\TH:i:s\Z');
    }

    public static function booleanToString($boolOrStr)
    {
        if (null === $boolOrStr || \is_string($boolOrStr)) {
            return $boolOrStr;
        }

        return $boolOrStr ? 'True' : 'False';
    }

    public static function jsonObject($object)
    {
        if (\is_array($object)) {
            return \json_encode($object);
        }

        return $object;
    }

    public static function map($values, $map_func)
    {
        if (!\is_array($values)) {
            return $values;
        }

        return \array_map($map_func, $values);
    }

    private static function flatten(array $map, array $result = [], array $previous = []): array
    {
        foreach ($map as $key => $value) {
            if (\is_array($value)) {
                $result = self::flatten($value, $result, \array_merge($previous, [$key]));
            } else {
                $result[\implode('.', \array_merge($previous, [$key]))] = $value;
            }
        }

        return $result;
    }
}
