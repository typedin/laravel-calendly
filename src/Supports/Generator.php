<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;

class Generator
{
    private PhpNamespace $namespace;

    private ClassType $class;

    private PhpFile $file;

    public function __construct(private Collection $blueprint)
    {
        $this->file = new PhpFile;
        $this->namespace = new PhpNamespace('Typedin\LaravelCalendly\Api');

        $this->class = new ClassType($this->buildClassName());
    }

    public function build(): array
    {
        collect($this->blueprint['methods'])
   ->filter(function ($data, $method_name) {
       return isset($data['parameters']);
   })
   ->each(function ($data, $method_name) {
       $this->buildMethodParams($method_name, collect($data['parameters']))
   ->addBody('$response = BaseApiClient::get("");')
   ->addBody('return new '.$this->buildModelName().'($response->json("resource"), "users"); ');
   });

        $this->namespace
             ->addUse(sprintf('Typedin\LaravelCalendly\Entities\%s\Calendly%s', $this->buildModelName(), $this->buildModelName()))
             ->add($this->class);

        $this->file->addNamespace($this->namespace);

        return [
            'file_name' => $this->buildClassName(),
            'content' => $this->file,
        ];
    }

    private function buildModelName(): string
    {
        $all = collect(explode(' ', $this->blueprint->get('name')))->map(fn ($value) => ucfirst($value));

        return 'Calendly'.Str::singular(implode($all->all()));
    }

    private function buildClassName(): string
    {
        $all = collect(explode(' ', $this->blueprint->get('name')))->map(fn ($value) => ucfirst($value));

        return implode($all->all()).'ApiClient';
    }

    private function buildMethodParams(string $method_name, Collection $parameters): Method
    {
        $method = $this->class->addMethod($method_name)->setStatic()->setReturnType(sprintf("\Typedin\LaravelCalendly\Entities\%s\Calendly%s", $this->buildModelName(), $this->buildModelName()));

        $parameters
            ->filter(fn ($param) => isset($param['name']))
            ->each(function ($value) use ($method) {
                $type = $value['schema']['type'] == 'integer' ? 'int' : $value['schema']['type'];
                $name = $value['name'];
                if (isset($value['required'])) {
                    $method->addParameter($name)->setType($type);
                } elseif (isset($value['schema']['default'])) {
                    $method->addParameter($name, $value['schema']['default'])->setType($type);
                } else {
                    $method->addParameter($name, null)->setType($type);
                }
            });

        return $method;
    }
}
