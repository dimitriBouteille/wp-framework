<?php

namespace Dbout\Wp\Framework\Validator;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class Validator
 * @package Dbout\Wp\Framework\Validator
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
abstract class Validator
{

    /**
     * Data that must be validated
     * @var array
     */
    protected array $validateData = [];

    /**
     * Valid data after validation
     * @var array
     */
    protected array $validData = [];

    /**
     * @var mixed
     */
    protected $hydrateObject;

    /**
     * @var ValidatorInterface
     */
    protected ValidatorInterface $validator;

    /**
     * @var array
     */
    protected array $errors = [];

    /**
     * @var ConstraintViolationList[]
     */
    protected array $violations = [];

    /**
     * @param $hydrateObject
     */
    public function __construct(&$hydrateObject = null)
    {
        $this->hydrateObject = $hydrateObject;
        $this->validator = Validation::createValidator();
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setValidateData(array $data): self
    {
        $this->validateData = $data;
        return $this;
    }

    /**
     * @param string $key
     * @param $data
     * @return $this
     */
    public function addValidateData(string $key, $data): self
    {
        $this->validateData[$key] = $data;
        return $this;
    }

    /**
     * @param mixed $object
     * @return $this
     */
    public function setHydrateObject(&$object): self
    {
        $this->hydrateObject = $object;
        return $this;
    }

    /**
     * @param bool $oneErrorByField
     * @return array
     */
    public function getErrors(bool $oneErrorByField = true): array
    {
        if (!$oneErrorByField) {
            return $this->errors;
        }

        $errors_ = [];
        foreach ($this->errors as $field => $errors) {
            $errors_[$field] = reset($errors);
        }

        return $errors_;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isValid(): bool
    {
        $this->reset();
        foreach ($this->getConstraints() as $fieldName => $field) {
            $value = $this->getValue($fieldName, $field);
            $violations = $this->validator->validate($value, $field->getConstraints());
            if(count($violations) > 0) {
                $this->violations[$fieldName] = $violations;
            } else {
                $this->validData[$fieldName] = $value;
            }
        }

        $this->buildsErrors();
        $this->hydrateObject();
        return !$this->hasErrors();
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    /**
     * @return $this
     */
    public function reset(): self
    {
        $this->errors = [];
        $this->validData = [];
        $this->violations = [];
        return $this;
    }

    /**
     * @return Field[]
     */
    protected abstract function getConstraints(): array;
    /**
     * @return void
     */
    protected function hydrateObject(): void
    {
        if (is_null($this->hydrateObject)) {
            return;
        }

        $accessor = PropertyAccess::createPropertyAccessor();
        foreach ($this->getConstraints() as $fieldName => $field) {
            $value = $this->getValidData($fieldName, $field);

            // By default, use default key
            if($field->getMappedProperty()) {
                $fieldName = $field->getMappedProperty();
            }

            try {
                $accessor->setValue($this->hydrateObject, $fieldName, $value);
            } catch (\Exception $exception) {}
        }
    }

    /**
     * @param string $key
     * @param Field $field
     * @return mixed|null
     */
    protected function getValidData(string $key, Field $field)
    {
        return $this->validData[$key] ?? null;
    }

    /**
     * @param string $fieldName
     * @param Field $field
     * @return mixed|null
     */
    protected function getValue(string $fieldName, Field $field)
    {
        return $this->validateData[$fieldName] ?? null;
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function buildsErrors(): void
    {
        foreach ($this->violations as $key => $violation) {
            foreach ($violation->getIterator() as $item) {
                /** @var ConstraintViolationInterface $item */
                $this->errors[$key][] = $item->getMessage();
            }
        }
    }
}
