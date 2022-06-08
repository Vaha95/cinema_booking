<?php

namespace App\Tests\Unit\Mock;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Mapping\MetadataInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class ValidatorExecutionContextMock implements ExecutionContextInterface
{
    private $violationMessages = [];
    private $hasViolations = false;
    private $violationBuilder;
    private $object;

    public function __construct()
    {
        $this->violationBuilder = new ViolationBuilderMock();
    }

    public function hasViolations(): bool
    {
        return $this->hasViolations;
    }

    public function getViolationMessages(): array
    {
        return $this->violationMessages;
    }

    public function addViolation($message, array $params = array())
    {
        $this->hasViolations = true;
        $this->violationMessages[] = $message;
    }

    public function getGroup(): ?string
    {
    }

    public function buildViolation($message, array $parameters = array()): ConstraintViolationBuilderInterface
    {
        $this->hasViolations = true;
        $this->violationMessages[] = $message;

        return $this->violationBuilder;
    }

    public function setObject($object): void
    {
        $this->object = $object;
    }

    public function getObject(): ?object
    {
        return $this->object;
    }

    public function getClassName(): ?string
    {
    }

    public function getMetadata(): ?MetadataInterface
    {
    }

    public function getPropertyName(): ?string
    {
    }

    public function getPropertyPath($subPath = ''): string
    {
    }

    public function getRoot(): mixed
    {
    }

    public function getValidator(): ValidatorInterface
    {
    }

    public function getValue(): mixed
    {
    }

    public function getViolations(): ConstraintViolationListInterface
    {
    }

    public function isConstraintValidated($cacheKey, $constraintHash): bool
    {
    }

    public function isGroupValidated($cacheKey, $groupHash): bool
    {
    }

    public function isObjectInitialized($cacheKey): bool
    {
    }

    public function markConstraintAsValidated($cacheKey, $constraintHash)
    {
    }

    public function markGroupAsValidated($cacheKey, $groupHash)
    {
    }

    public function markObjectAsInitialized($cacheKey)
    {
    }

    public function setConstraint(Constraint $constraint)
    {
    }

    public function setGroup($group)
    {
    }

    public function setNode($value, $object, MetadataInterface $metadata = null, $propertyPath)
    {
    }
}
