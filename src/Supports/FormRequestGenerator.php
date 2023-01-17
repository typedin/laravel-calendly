<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Collection;
use Nette\PhpGenerator\ClassType;

class FormRequestGenerator
{
    public ClassType $validator;

    public function __construct(private readonly string $name, private readonly array $schema)
    {
        $this->validator = new ClassType(sprintf('%sRequest', $this->name));

        $this->validator->addMethod('rules')->addBody('return [');
        $this->fieldValidationPairs()->each(function ($value, $key) {
            $this->validator->getMethod('rules')->addBody(sprintf("'%s' => '%s',", $key, implode(',', $value)));
        });
        $this->validator->getMethod('rules')->addBody('];');
        $this->validator->validate();
    }

    private function fieldValidationPairs(): Collection
    {
        $not_nested = collect($this->schema['properties'])
                        ->flatMap(fn ($value, $key) => [$key => $this->buildValidation($value, $key, $this->schema['required'])]);

        $nested = collect($this->schema['properties'])
                        ->filter(fn ($value) => isset($value['items']['properties']))
                        ->flatMap(function ($value, $key) {
                            $requirements = $value['items']['required'] ?? [];
                            $nested_value = $key.'.*.';

                            return collect($value['items']['properties'])->flatMap(fn ($value, $key) => [$nested_value.$key => $this->buildValidation($value, $key, $requirements)])->all();
                        });

        return $not_nested->merge($nested);
    }

    /**
     * @return string[]
     */
    private function buildValidation($value, $key, $requirements): array
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
