<?php

namespace Api\Contracts;

interface EntityInterface {
    public function fill(array $attributes): void;
    public function toArray(): array;
}
