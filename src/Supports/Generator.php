<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;

class Generator
{
    private PhpFile $file;

    private ClassType $class;

    private PhpNamespace $namespace;

    public function __construct(private Collection $blueprint)
    {
        $this->file = new PhpFile;
        $this->class = new ClassType($this->buildClassName());
        $this->namespace = new PhpNamespace('Typedin\LaravelCalendly\Api');
    }

    /**
     * @return array<string,mixed>
     */
    public function build(): array
    {
        collect($this->blueprint)
               ->each(function ($value) {
                   MethodGenerator::generate($this->class,
                       $this->buildModelName(),
                       $value);
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
