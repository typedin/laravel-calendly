<?php

namespace Typedin\LaravelCalendly\Entities;

use Illuminate\Support\Collection;
use ReflectionObject;
use ReflectionProperty;

abstract class CalendlyBaseClass
{
    /**
     * @return Collection<TKey,TValue>
     */
    protected function keys(): Collection
    {
        $allPublicProperties = (new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC);

        return collect($allPublicProperties)
            ->map(fn ($item) => $item->name)
            ->filter(fn ($name) => $name !== 'uuid');
    }
}
