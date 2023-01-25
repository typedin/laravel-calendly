<?php

namespace Typedin\LaravelCalendly\Supports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Throwable;
use Typedin\LaravelCalendly\Supports\DTO\FormRequestDTO;
use Typedin\LaravelCalendly\Supports\DTO\IndexFormRequestDTO;
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
    public function __construct(private readonly FormRequestDTO $dto)
    {
        $this->http_method = $this->dto->httpMethod();
        $this->validator = new ClassType(sprintf('%s%sRequest', $this->verb(), $this->wantsIndex() ? Str::plural($this->dto->name) : Str::singular($this->dto->name)));

        $this->validator->setExtends('Illuminate\Foundation\Http\FormRequest');
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
        return  $this->dto instanceof IndexFormRequestDTO;
    }

    private function fieldValidationPairs(): Collection
    {
        $rules_from_request_body = collect($this->dto->requestBody())
                ->map(fn ($value) => collect($value['schema']['properties']))
                ->flatMap(fn ($property) => $property->flatMap(fn ($value, $key) => [$key => $this->buildValidation(
                    value: $value,
                    field: $key,
                    requirements: $this->dto->requestBody()['application/json']['schema']['required'] ?? []
                )]));

        $rules_from_parameters = collect($this->dto->parameters())
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
