<?php

namespace core\validation;

use core\validation\traits\Validation;

class Main
{
    use Validation;

    public function validate(array $values): bool
    {
        $valid = true;

        $_SESSION['valedation'] = [];

        foreach ($values as $input => $rules) {

            $value = $_POST[$input] ?? null;

            foreach ($rules as $rule) {

                $parts = explode(':', $rule, 2);

                $method = $parts[0];

                $parameters = isset($parts[1])
                    ? explode(',', $parts[1])
                    : [];

                if (!method_exists($this, $method)) {
                    throw new \InvalidArgumentException(
                        "Validation rule [$method] does not exist."
                    );
                }

                if (!$this->$method($value, ...$parameters)) {

                    $valid = false;

                    $_SESSION['valedation'][$input] =
                        "The {$input} field failed the {$method} rule.";

                    break;
                }
            }
        }

        if (!$valid) {
          header('Location: ' . $GLOBALS['basePath'] . $GLOBALS['previousUrl']);
        }

        return $valid;
    }
}
