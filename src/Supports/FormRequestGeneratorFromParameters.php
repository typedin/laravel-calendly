<?php

namespace Typedin\LaravelCalendly\Supports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Throwable;
use Typedin\LaravelCalendly\traits\UseCrudVerbs;

class FormRequestGeneratorFromParameters
{
    use UseCrudVerbs;

    public ClassType $validator;

    private string $http_method;

    /**
     * @param  array<int,mixed>  $path
     * @param  array<int,mixed>  $parameters
     */
    public function __construct(private readonly string $name, private readonly array $path)
    {
        $this->http_method = collect($this->path)->keys()->reject(fn ($value) => $value == 'parameters')->first();

        $this->validator = new ClassType(sprintf('%s%sRequest', $this->verb(), $this->wantsIndex() ? Str::plural($this->name) : Str::singular($this->name)));

        $this->validator->addMethod('rules')->addBody('return [');

        $this->fieldValidationPairs()->each(function ($value, $key) {
            $this->validator->getMethod('rules')->addBody(sprintf("'%s' => '%s',", $key, implode(',', $value)));
        });
        $this->validator->getMethod('rules')->addBody('];')->setReturnType(type: 'array');
        $this->validator->validate();
    }

    private function verb(): string
    {
        if ($this->wantsIndex()) {
            return $this->CRUD_OPERATIONS['index'];
        }

        return $this->CRUD_OPERATIONS[$this->http_method];
    }

    private function wantsIndex(): bool
    {
        // Index :
        // get without parameters
        // get + empty top level parameters
        // Show :
        // get + top level parameters
        // Store :
        // post + top level parameters
        // Destroy
        // delete + top level parameters
        return ! (isset($this->path['parameters']) && ! empty($this->path['parameters']));
    }

    private function fieldValidationPairs(): Collection
    {
        $nested_parameters = $this->path[$this->http_method]['requestBody']['content'] ?? [];
        $rules_from_request_body = collect($nested_parameters)
                ->map(fn ($value) => collect($value['schema']['properties']))
                ->flatMap(fn ($property) => $property->flatMap(function ($value, $key) use ($nested_parameters) {
                    return [$key => $this->buildValidation(
                        value: $value,
                        field: $key,
                        requirements: $nested_parameters['application/json']['schema']['required'] ?? [])];
                }));

        $parameters = $this->path[$this->http_method]['parameters'] ?? $this->path['parameters'];
        $rules_from_parameters = collect($parameters)
                ->filter(fn ($value) => isset($value['name']))
               ->flatMap(function ($value) {
                   try {
                       if (isset($value['example'])) {
                           Carbon::parse($value['example']);
                           $value['schema']['type'] = 'date-time';
                       }
                   } catch (Throwable) {
                       // do nothing
                   }

                   return [$value['name'] => $this->buildValidation(
                       value: $value['schema'],
                       field: $value['name'],
                       requirements: isset($value['required']) && $value['required'] ? [$value['name']] : []
                   )];
               });

        return $rules_from_parameters->merge($rules_from_request_body);
    }

    /**
     * @param  array<int,mixed>  $value
     * @param  string  $field
     * @param  array<int,mixed>  $requirements
     * @return string[]
     */
    private function buildValidation(array $value, string $field, array $requirements): array
    {
        $local = [];
        if (in_array($field, $requirements)) {
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
