<?php

abstract class AbstractCsvValidator
{
    protected $schema = [];

    private $errors = [];

    public function validateSchema(array $header)
    {
        if (count(array_diff(array_keys($this->schema), $header)) !== 0) {
            $this->addError('Invalid Schema');
        }
    }

    public function validateLine(array $line)
    {
        foreach ($line as $element => $value) {
            $this->validateElement($element, $value);
        }

        $this->checkExtraCondition($line);
    }


    private function validateElement($element, $value)
    {
        $this->checkIsRequired($element, $value);
        $this->checkType($element, $value);
        $this->checkLength($element, $value);
    }

    /**
     * @param $element
     * @param $value
     */
    private function checkIsRequired($element, $value)
    {
        if (isset($this->schema[$element]['required']) && $this->schema[$element]['required'] === true) {
            if (empty($value)) {
                $this->addError("$element shouldn't be blank");
            }
        }
    }

    /**
     * @param $element
     * @param $value
     */
    private function checkType($element, $value)
    {
        $type = $this->schema[$element]['type'];

        $typeMethodCheck = 'is' . ucfirst($type);

        if(!empty($value) && !TypeCheckerService::$typeMethodCheck($value)) {
            $this->addError("$element should be $type");
        }
    }

    /**
     * @param $element
     * @param $value
     */
    private function checkLength($element, $value)
    {
        if (empty($value)) {
            return;
        }

        if (isset($this->schema[$element]['length'])) {
            $schemaElementLength = $this->schema[$element]['length'];
            $elementLength = strlen($value);

            if (!is_array($schemaElementLength)) {
                if ($schemaElementLength !== $elementLength) {
                    $this->addError("The length of $element should be $schemaElementLength");
                }

                return;
            }

            $schemaElementLengthMin = $schemaElementLength['min'];
            $schemaElementLengthMax = $schemaElementLength['max'];

            if ($elementLength < $schemaElementLengthMin|| $elementLength > $schemaElementLengthMax) {
                $this->addError(
                    "The length of $element should be between $schemaElementLengthMin and $schemaElementLengthMax"
                );
            }
        }
    }

    /**
     * @param array $line
     */
    abstract public function checkExtraCondition(array $line);

    /**
     * @param $error
     */
    public function addError($error)
    {
        $this->errors[] = $error;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function resetErrors()
    {
        $this->errors = [];
    }
}