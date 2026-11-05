<?php

namespace core\validation\traits;

trait Validation
{
    public function required($value): bool
    {
        return !(
            $value === null ||
            (is_string($value) && trim($value) === '') ||
            (is_array($value) && empty($value))
        );
    }

    public function email($value): bool
    {
        return $value === null || filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function min($value, int $min): bool
    {
        if ($value === null) return true;

        if (is_string($value) || is_array($value)) {
            return mb_strlen((string) $value) >= $min;
        }

        return is_numeric($value) && $value >= $min;
    }

    public function max($value, int $max): bool
    {
        if ($value === null) return true;

        if (is_string($value)) {
            return mb_strlen($value) <= $max;
        }

        if (is_array($value)) {
            return count($value) <= $max;
        }

        return is_numeric($value) && $value <= $max;
    }

    public function numeric($value): bool
    {
        return $value === null || is_numeric($value);
    }

    public function integer($value): bool
    {
        return $value === null || filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    public function string($value): bool
    {
        return $value === null || is_string($value);
    }

    public function boolean($value): bool
    {
        return $value === null || in_array($value, [true, false, 0, 1, '0', '1'], true);
    }

    public function confirmed($value, $confirmation): bool
    {
        return $value === null || $value === $confirmation;
    }

    public function same($value, $other): bool
    {
        return $value === null || $value === $other;
    }

    public function alpha($value): bool
    {
        return $value === null || (
            is_string($value) && preg_match('/^\p{L}+$/u', $value) === 1
        );
    }

    public function alphaNumeric($value): bool
    {
        return $value === null || (
            is_string($value) &&
            preg_match('/^[\p{L}\p{N}]+$/u', $value) === 1
        );
    }

    public function regex($value, string $pattern): bool
    {
        return $value === null || (
            is_string($value) && @preg_match($pattern, $value) === 1
        );
    }
}
