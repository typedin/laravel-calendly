<?php

namespace Typedin\LaravelCalendly\Supports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Throwable;
use Typedin\LaravelCalendly\Supports\Configuration\FormRequestProvider;
use Typedin\LaravelCalendly\Supports\Configuration\IndexFormRequestProvider;
use Typedin\LaravelCalendly\traits\UseCrudVerbs;

class FormRequestGenerator
{
    use UseCrudVerbs;

    public readonly ClassType $validator;

    private function __construct(private readonly FormRequestProvider $provider)
    {
    }

    public static function formRequest(FormRequestProvider $provider): ClassType
    {
        $generator = new FormRequestGenerator($provider);

        $generator->validator = new ClassType(
            name: sprintf('%s%sRequest', $generator->verb(), $generator->wantsIndex() ? Str::plural($generator->provider->name) : Str::singular($generator->provider->name)),
            namespace: new PhpNamespace('Typedin\LaravelCalendly\Models')
        );

        $generator->generateConstructor()->generateProperties();
        $generator->validator->validate();

        return $generator->validator;
    }

    private function generateConstructor(): FormRequestGenerator
    {
        $this->validator->setExtends('Illuminate\Foundation\Http\FormRequest');

        return $this;
    }

    private function generateProperties(): FormRequestGenerator
    {
        $this->validator->addMethod('rules')->addBody('return [');

        $this->fieldValidationPairs()->each(function ($value, $key) {
            $this->validator->getMethod('rules')->addBody(sprintf("'%s' => '%s',", $key, implode(',', $value)));
        });
        $this->validator->getMethod('rules')->addBody('];')->setReturnType(type: 'array');

        return $this;
    }

    private function verb(): string
    {
        if ($this->wantsIndex()) {
            return $this->CRUD_OPERATIONS['index'];
        }

        return $this->CRUD_OPERATIONS[$this->provider->httpMethod()];
    }

    private function wantsIndex(): bool
    {
        return  $this->provider instanceof IndexFormRequestProvider;
    }

    private function fieldValidationPairs(): Collection
    {
        $rules_from_request_body = collect($this->provider->requestBody())
                ->map(fn ($value) => collect($value['schema']['properties']))
                ->flatMap(fn ($property) => $property->flatMap(fn ($value, $key) => [$key => $this->buildValidation(
                    value: $value,
                    field: $key,
                    requirements: $this->provider->requestBody()['application/json']['schema']['required'] ?? []
                )]));

        $rules_from_parameters = collect($this->provider->parameters())
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
