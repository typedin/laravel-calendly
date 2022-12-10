<?php

namespace Typedin\LaravelCalendly\traits;

use Illuminate\Support\Collection;
use ReflectionObject;
use ReflectionProperty;

trait HasAssignableKeys
{
    /**
     * @return Collection<TKey,TValue>
     */
    private function keys(): Collection
    {
        $allPublicProperties = (new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC);

        return collect($allPublicProperties)
            ->map(fn ($item) => $item->name)
            ->filter(fn ($name) => $name !== 'uuid');
    }
}
