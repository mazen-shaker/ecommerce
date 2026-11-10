<?php

namespace core\validation\traits;

trait Validation
{
    private function isFileInput($value): bool
    {
        if (
            is_array($value) &&
            isset($value['name'], $value['tmp_name'], $value['error'], $value['size'])
        ) {
            return true;
        }

        if (is_array($value) && count($value) === 1) {
            $file = reset($value);

            return is_array($file) &&
                isset($file['name'], $file['tmp_name'], $file['error'], $file['size']);
        }

        return false;
    }

    private function getFileEntries($value): array
    {
        if (!$this->isFileInput($value)) {
            return [];
        }

        if (!isset($value['name'])) {
            $value = reset($value);
        }

        $files = [];

        $names = is_array($value['name']) ? $value['name'] : [$value['name']];
        $tmpNames = is_array($value['tmp_name']) ? $value['tmp_name'] : [$value['tmp_name']];
        $errors = is_array($value['error']) ? $value['error'] : [$value['error']];
        $sizes = is_array($value['size']) ? $value['size'] : [$value['size']];

        foreach ($names as $index => $name) {
            $file = [
                'name' => $name,
                'tmp_name' => $tmpNames[$index] ?? '',
                'error' => $errors[$index] ?? UPLOAD_ERR_NO_FILE,
                'size' => $sizes[$index] ?? 0,
            ];

            if ($file['error'] !== UPLOAD_ERR_NO_FILE) {
                $files[] = $file;
            }
        }

        return $files;
    }

    private function hasValidFiles($value): bool
    {
        $files = $this->getFileEntries($value);

        if (empty($files)) {
            return false;
        }

        foreach ($files as $file) {
            if (
                $file['error'] !== UPLOAD_ERR_OK ||
                empty($file['tmp_name']) ||
                !is_uploaded_file($file['tmp_name'])
            ) {
                return false;
            }
        }

        return true;
    }

    private function shouldSkip($value): bool
    {
        if ($this->isFileInput($value)) {
            return empty($this->getFileEntries($value));
        }

        return $value === null ||
            (is_string($value) && trim($value) === '');
    }

    public function required($value): bool
    {
        if ($this->isFileInput($value)) {
            return $this->hasValidFiles($value);
        }

        return !(
            $value === null ||
            (is_string($value) && trim($value) === '') ||
            (is_array($value) && empty($value))
        );
    }

    public function file($value): bool
    {
        return $this->shouldSkip($value) || $this->hasValidFiles($value);
    }

    public function image($value): bool
    {
        if ($this->shouldSkip($value)) return true;

        if (!$this->hasValidFiles($value)) return false;

        foreach ($this->getFileEntries($value) as $file) {
            if (@getimagesize($file['tmp_name']) === false) {
                return false;
            }
        }

        return true;
    }

    public function mimes($value, string $extensions): bool
    {
        if ($this->shouldSkip($value)) return true;

        if (!$this->hasValidFiles($value)) return false;

        $allowed = explode(',', $extensions);

        foreach ($this->getFileEntries($value) as $file) {
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        }

        if (!in_array($extension, $allowed, true)) {
            return false;
        }
        return true;
    }

    public function min($value, int $min): bool
    {
        if ($this->shouldSkip($value)) return true;

        if ($this->isFileInput($value)) {
            if (!$this->hasValidFiles($value)) return false;

            foreach ($this->getFileEntries($value) as $file) {
                if ($file['size'] < $min * 1024) return false;
            }

            return true;
        }

        if (is_string($value) || is_array($value)) {
            return mb_strlen((string) $value) >= $min;
        }

        return is_numeric($value) && $value >= $min;
    }

    public function max($value, int $max): bool
    {
        if ($this->shouldSkip($value)) return true;

        if ($this->isFileInput($value)) {
            if (!$this->hasValidFiles($value)) return false;

            foreach ($this->getFileEntries($value) as $file) {
                if ($file['size'] > $max * 1024) return false;
            }

            return true;
        }

        if (is_string($value)) {
            return mb_strlen($value) <= $max;
        }

        if (is_array($value)) {
            return count($value) <= $max;
        }

        return is_numeric($value) && $value <= $max;
    }

    public function email($value): bool
    {
        return $this->shouldSkip($value) || filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function numeric($value): bool
    {
        return $this->shouldSkip($value) || is_numeric($value);
    }

    public function integer($value): bool
    {
        return $this->shouldSkip($value) || filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    public function string($value): bool
    {
        return $this->shouldSkip($value) || is_string($value);
    }

    public function boolean($value): bool
    {
        return $this->shouldSkip($value) || in_array($value, [true, false, 0, 1, '0', '1'], true);
    }

    public function confirmed($value, $confirmation): bool
    {
        return $this->shouldSkip($value) || $value === $confirmation;
    }

    public function same($value, $other): bool
    {
        return $this->shouldSkip($value) || $value === $other;
    }

    public function alpha($value): bool
    {
        return $this->shouldSkip($value) || (
            is_string($value) && preg_match('/^\p{L}+$/u', $value) === 1
        );
    }

    public function alphaNumeric($value): bool
    {
        return $this->shouldSkip($value) || (
            is_string($value) &&
            preg_match('/^[\p{L}\p{N}]+$/u', $value) === 1
        );
    }

    public function regex($value, string $pattern): bool
    {
        return $this->shouldSkip($value) || (
            is_string($value) && @preg_match($pattern, $value) === 1
        );
    }
}
