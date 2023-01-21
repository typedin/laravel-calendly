<?php

namespace Typedin\LaravelCalendly\Supports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Nette\PhpGenerator\ClassType;

class FormRequestGeneratorFromParameters
{
    public ClassType $validator;

    /**
     * @param  string  $name
     * @param  array<int,mixed>  $path
     */
    public function __construct(private readonly string $name, private readonly array $path)
    {
        $this->validator = new ClassType(sprintf('%s%sRequest', $this->verb(), $this->name));

        $this->validator->addMethod('rules')->addBody('return [');

        $this->fieldValidationPairs()->each(function ($value, $key) {
            $this->validator->getMethod('rules')->addBody(sprintf("'%s' => '%s',", $key, implode(',', $value)));
        });
        $this->validator->getMethod('rules')->addBody('];')->setReturnType(type: 'array');
        $this->validator->validate();
    }

    private function verb(): string
    {
        if (isset($this->path['get'])) {
            return 'Index';
        }
    }

    private function fieldValidationPairs(): Collection
    {
        $parameters = isset($this->path['get']['parameters']) ? $this->path['get']['parameters'] : $this->path['parameters'];

        return collect($parameters)
                ->filter(function ($value) {
                    return isset($value['name']);
                })
               ->flatMap(function ($value) {
                   try {
                       if (isset($value['example'])) {
                           Carbon::parse($value['example']);
                           $value['schema']['type'] = 'date-time';
                       }
                   } catch (\Throwable $ignored) {
                       // do nothing
                   }
                    $local_requirements = isset($value['required']) && $value['required'] ? [$value['name']] : [];

                   return [$value['name'] => $this->buildValidation($value['schema'], $value['name'], $local_requirements)];
               });
    }

    /**
     * @param  mixed  $value
     * @param  mixed  $key
     * @param  mixed  $requirements
     * @return string[]
     */
    private function buildValidation($value, $key, array $requirements): array
    {
        $local = [];
        if (in_array($key, $requirements)) {
            $local[] = isset($value['nullable']) && $value['nullable'] == true
                ? 'nullable'
                : 'required';
        }
        if (isset($value['enum'])) {
            $local[] = sprintf('in:%s', implode(',', $value['enum']));
        } elseif (isset($value['pattern'])) {
            $local[] = 'regex:'.$value['pattern'];
        } elseif (isset($value['format'])) {
            $local[] = $this->getFormat($value['format']);
        } elseif (isset($value['type'])) {
            $local[] = $this->getFormat($value['type']);
        }

        return $local;
    }

    private function getFormat(string $needle): string
    {
        $local = [
            'date-time' => 'date',
            'number' => 'numeric',
            'uri' => 'url',
        ];

        return $local[$needle] ?? $needle;
    }
}
