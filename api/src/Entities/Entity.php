<?php

namespace Api\Entities;

use Api\Contracts\EntityInterface;

abstract class Entity implements EntityInterface {
    protected array $fillable = [];
    protected array $hidden   = [];

    public function __construct(array $attributes = []) {
        $this->fill($attributes);
    }

    public function fill(array $attributes): void
    {
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->{$key} = $value;
            }
        }
    }

    public function toArray(): array {
        $attributes = get_object_vars($this);

        foreach (array_merge($this->hidden, ['fillable', 'hidden']) as $key) {
            unset($attributes[$key]);
        }

        return $attributes;
    }
}
