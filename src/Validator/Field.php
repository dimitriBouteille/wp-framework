<?php

namespace Dbout\Wp\Framework\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class Field
 * @package Dbout\Wp\Framework\Validator
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class Field
{

    /**
     * @var Constraint[]
     */
    protected array $constraints = [];

    /**
     * Name of the property that is mapped
     * @var string|null
     */
    protected ?string $mappedProperty;

    /**
     * @param array $constraints
     * @param string|null $mappedProperty
     */
    public function __construct(array $constraints, ?string $mappedProperty = null)
    {
        $this->constraints = $constraints;
        $this->mappedProperty = $mappedProperty;
    }

    /**
     * @param Constraint $constraint
     * @return $this
     */
    public function addConstraint(Constraint $constraint): self
    {
        $this->constraints[] = $constraint;
        return $this;
    }

    /**
     * @param array $constraints
     * @return $this
     */
    public function setConstraints(array $constraints): self
    {
        $this->constraints = $constraints;
        return $this;
    }

    /**
     * @return array|Constraint[]
     */
    public function getConstraints(): array
    {
        return $this->constraints;
    }

    /**
     * @return string|null
     */
    public function getMappedProperty(): ?string
    {
        return $this->mappedProperty;
    }

    /**
     * @param string|null $mappedProperty
     * @return $this
     */
    public function setMappedProperty(?string $mappedProperty): self
    {
        $this->mappedProperty = $mappedProperty;
        return $this;
    }
}