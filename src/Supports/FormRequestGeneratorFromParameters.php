<?php

namespace Typedin\LaravelCalendly\Supports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Throwable;

class FormRequestGeneratorFromParameters
{
    final public const HTTP_VERB = [
        'get' => ['singular' => 'Show', 'plural' => 'Index'],
        'post' => ['singular' => 'Post', 'plural' => 'Post'],
        'delete' => ['singular' => 'Destroy', 'plural' => 'Destroy'],
    ];

    public ClassType $validator;

    /**
     * @param  array<int,mixed>  $path
     * @param  array<int,mixed>  $parameters
     */
    public function __construct(private readonly string $name, private readonly string $verb, private readonly array $path)
    {
        $this->validator = new ClassType(sprintf('%s%sRequest', $this->verb(), $this->isSingular() ? Str::singular($this->name) : Str::plural($this->name)));

        $this->validator->addMethod('rules')->addBody('return [');

        $this->fieldValidationPairs()->each(function ($value, $key) {
            $this->validator->getMethod('rules')->addBody(sprintf("'%s' => '%s',", $key, implode(',', $value)));
        });
        $this->validator->getMethod('rules')->addBody('];')->setReturnType(type: 'array');
        $this->validator->validate();
    }

    private function verb(): string
    {
        return self::HTTP_VERB[$this->verb][$this->isSingular() ? 'singular' : 'plural'];
    }

    private function isSingular(): bool
    {
        return false;
    }

    private function fieldValidationPairs(): Collection
    {
        $parameters = $this->path['parameters'] ?? $this->path;

        return collect($parameters)
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
                    $local_requirements = isset($value['required']) && $value['required'] ? [$value['name']] : [];

                   return [$value['name'] => $this->buildValidation($value['schema'], $value['name'], $local_requirements)];
               });
    }

    /**
     * @param  mixed  $requirements
     * @return string[]
     */
    private function buildValidation(mixed $value, mixed $key, array $requirements): array
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
