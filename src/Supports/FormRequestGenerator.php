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

    private function createRules()
    {
        $rules = collect($this->schema['properties'])
            ->map(function ($value, $key) {
                $local = [];
                if (in_array($key, $this->schema['required'])) {
                    $local[] = 'required';
                }
                if (isset($value['enum'])) {
                    $local[] = sprintf('in:%s', implode(',', $value['enum']));
                } elseif (isset($value['pattern'])) {
                    $local[] = "regex:".$value['pattern'];
                } elseif (isset($value['format'])) {
                    if ($value['format'] == 'date-time') {
                        $local[] = 'date';
                    } elseif ($value['format'] == 'uri') {
                        $local[] = 'url';
                    } elseif ($value['format'] == 'number') {
                        $local[] = 'numeric';

                    }  
                } elseif (isset($value['type'])) {
                    $local[] = $value['type'];
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
