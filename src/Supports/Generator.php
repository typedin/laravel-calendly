<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
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

    /**
     * @return array<string,mixed>
     */
    public function build(): array
    {
        collect($this->blueprint['methods'])
                ->filter(fn ($data) => isset($data['parameters']))
               ->each(function ($data, $method_name) {
                   MethodGenerator::handle($this->class, $this->buildModelName(), $method_name, collect($data['parameters']));
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

    private function getName(): string
    {
        return Str::of($this->blueprint->get('name'))->trim();
    }

    private function buildModelName(): string
    {
        $all = collect(explode(' ', $this->getName()))
                    ->map(fn ($value) => ucfirst($value));

        return 'Calendly'.Str::singular(implode($all->all()));
    }

    private function buildClassName(): string
    {
        $all = collect(explode(' ', $this->getName()))
                    ->map(fn ($value) => ucfirst($value));

        return implode($all->all()).'ApiClient';
    }
}
