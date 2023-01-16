<?php

namespace Typedin\LaravelCalendly\Supports;

use Nette\PhpGenerator\ClassType;

class FormRequestGenerator
{
    public ClassType $validator;

    public function __construct(private readonly string $name, private readonly array $schema)
    {
        $this->validator = new ClassType(sprintf('%sRequest', $this->name));

        $this->createRules();
        $this->validator->validate();
    }

    private function getFormat(string $needle): string
    {
        $local = [
            'date-time' => 'date',
            'uri' => 'url',
            'number' => 'numeric',
        ];

        return $local[$needle];
    }

    private function getType(string $needle): string
    {
        $local = ['number' => 'numeric'];

        return $local[$needle] ?? $needle;
    }

    private function createRules(): FormRequestGenerator
    {
        $rules = collect($this->schema['properties'])
            ->map(function ($value, $key) {
                $local = [];
                if (in_array($key, $this->schema['required'])) {
                    $local[] = 'required';
                }
                if (isset($value['nullable']) && $value['nullable'] == true) {
                    $local[0] = 'nullable';
                }

                if (isset($value['enum'])) {
                    $local[] = sprintf('in:%s', implode(',', $value['enum']));
                } elseif (isset($value['pattern'])) {
                    $local[] = 'regex:'.$value['pattern'];
                } elseif (isset($value['format'])) {
                    $local[] = $this->getFormat($value['format']);
                } elseif (isset($value['type'])) {
                    $local[] = $this->getType($value['type']);
                }

                return implode(',', $local);
            });

        $this->validator->addMethod('rules')->addBody('return [');

        $rules->each(function ($value, $key) {
            $this->validator->getMethod('rules')->addBody(sprintf("'%s' => '%s',", $key, $value));
        });

        $this->validator->getMethod('rules')->addBody('];');

        return $this;
    }
}
