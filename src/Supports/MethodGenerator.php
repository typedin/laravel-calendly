<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Collection;
use Nette\PhpGenerator\Method;

class MethodGenerator
{
    private Method $method;

    private function __construct(private string $uri, private array $data)
    {
        $this->method = new Method($this->buildMethodName($data));
    }

    public static function generate(string $uri, array $data): Method
    {
        $generator = new self($uri, $data);
        $generator->method
                  ->setVisibility('public')
                  ->setStatic(true)
                  ->setReturnType('Typedin\LaravelCalendly\Entities\ScheduledEvent\CalendlyScheduledEvent');

        $generator->buildDoc();
        $generator->buildMethodParameters();
        $generator->buildBody();

        return $generator->method;
    }

    private function buildMethodName(): string
    {
        return implode(explode(' ', $this->data['summary']));
    }

    private function getParametersFromData(): Collection
    {
        if (! isset($this->data['parameters'])) {
            return collect();
        }

        return collect($this->data['parameters'])->filter(fn ($value) => isset($value['name']));
    }

    private function buildDoc(): void
    {
        $this->method
                    ->addComment('\**')
                    ->addComment('* '.$this->data['summary'])
                    ->addComment('*');

        $this->getParametersFromData()->each(function ($value) {
            $this->method
                ->addComment(
                    sprintf('* @param %s $%s %s', $value['schema']['type'], $value['name'], $value['description'] ?? '')
                );
        });
        $this->method->addComment('*/');
    }

    private function buildMethodParameters(): void
    {
        $this->getParametersFromData()->each(function ($value) {
            $this->method->addParameter($value['name'], isset($value['schema']['default']) ? $value['schema']['default'] : null)
                // not tested by I know it will happen
                ->setType($value['schema']['type'] == 'integer' ? 'int' : $value['schema']['type'])
                ->setNullable(! isset($value['required']));
        });
    }

    private function buildBody(): void
    {
        $this->method
             ->addBody(sprintf('$response = BaseApiClient::%s("%s");', $this->data['rest_verb'], $this->buildUri()))
             ->addBody('return new CalendlyScheduledEvent($response->json("resource"), "users")');
    }

   private function buildUri(): string
   {
       return str_replace_first('{uuid}', '{$uuid}', $this->uri);
   }
}
