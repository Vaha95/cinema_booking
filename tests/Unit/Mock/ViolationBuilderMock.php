<?php

namespace App\Tests\Unit\Mock;

use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class ViolationBuilderMock implements ConstraintViolationBuilderInterface
{
    public function atPath($path): static
    {
        return $this;
    }

    public function setParameter($key, $value): static
    {
        return $this;
    }

    public function setParameters(array $parameters): static
    {
        return $this;
    }

    public function setTranslationDomain($translationDomain): static
    {
        return $this;
    }

    public function setInvalidValue($invalidValue): static
    {
        return $this;
    }

    public function setPlural($number): static
    {
        return $this;
    }

    public function setCode($code): static
    {
        return $this;
    }

    public function setCause($cause): static
    {
        return $this;
    }

    public function addViolation()
    {
    }
}
