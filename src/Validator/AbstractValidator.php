<?php

namespace Dbout\Wp\Framework\Validator;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractValidator
 * @package Dbout\Wp\Framework\Validator
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
abstract class AbstractValidator
{

    /**
     * @var array
     */
    protected array $dataValidate;

    /**
     * @var mixed
     */
    protected $object;

    /**
     * @var ValidatorInterface
     */
    protected ValidatorInterface $validator;

    /**
     * @var PropertyAccessor
     */
    protected PropertyAccessor $accessor;

    /**
     * @var ConstraintViolationList[]
     */
    protected array $errors = [];

    /**
     * @var string[]
     */
    protected array $validateData = [];

    /**
     * @param $object
     */
    public function __construct(&$object = null)
    {
        $this->object = $object;
        $this->validator = $this->createValidator();
        $this->accessor = $this->createPropertyAccess();
    }

    /**
     * @return array
     */
    abstract protected function getConstraints(): array;

    /**
     * @param array $dataValidate
     * @return bool
     */
    public function isValid(array $dataValidate = []): bool
    {
        $this->dataValidate = $dataValidate;
        foreach ($this->getConstraints() as $fieldName => $constraints) {
            if (count($constraints) === 0) {
                continue;
            }

            $value = $this->getDataValidate($fieldName);
            $violations = $this->validator->validate($value, $constraints);
            if (count($violations) > 0) {
                $this->errors[$fieldName] = $violations;
            } else {
                $this->validateData[$fieldName] = $value;
            }
        }

        if (count($this->errors) > 0) {
            return false;
        }

        $this->hydrateObject();
        return true;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        $errors = [];
        foreach ($this->errors as $fieldName => $violations) {
            // Get only first errors
            $errors[$fieldName] = $violations->get(0)->getMessage();
        }

        return $errors;
    }

    /**
     * @return void
     */
    protected function hydrateObject(): void
    {
        foreach ($this->getConstraints() as $fieldName => $constraints) {
            $value = $this->getDataValidate($fieldName);
            try {
                $this->accessor->setValue($this->object, $fieldName, $value);
            } catch (\Exception $exception) {
            }
        }
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    protected function getDataValidate(string $key)
    {
        return $this->dataValidate[$key] ?? null;
    }

    /**
     * @return ValidatorInterface
     */
    protected function createValidator(): ValidatorInterface
    {
        return Validation::createValidator();
    }

    /**
     * @return PropertyAccessor
     */
    protected function createPropertyAccess(): PropertyAccessor
    {
        return PropertyAccess::createPropertyAccessorBuilder()
            ->enableExceptionOnInvalidIndex()
            ->disableMagicSet()
            ->getPropertyAccessor();
    }
}