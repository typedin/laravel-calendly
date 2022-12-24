<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Collection;
use Nette\PhpGenerator\Method;

class MethodGenerator
{
    private readonly Method $method;

    private function __construct(private readonly string $uri, private array $data)
    {
        $this->method = new Method($this->buildMethodName());
    }

    public static function generate(string $uri, array $data): Method
    {
        $generator = new self($uri, $data);
        $generator->method
                  ->setVisibility('public')
                  ->setStatic(true)
                  ->setReturnType(\Typedin\LaravelCalendly\Entities\ScheduledEvent\CalendlyScheduledEvent::class);

        $generator->buildDoc();
        $generator->buildMethodParameters();
        $generator->buildBody();

        return $generator->method;
    }

    private function buildMethodName(): string
    {
        $local = explode(' ', (string) $this->data['summary']);
        foreach ($local as $key => $value) {
            if (str_ends_with($value, "'s")) {
                $local[$key] = str_replace("'s", '', $value);
            }
        }

        return implode($local);
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
        $this->method->addComment($this->data['summary']);

        $this->getParametersFromData()->each(function ($value) {
            $this->method
                ->addComment(
                    sprintf('@param %s $%s %s', $value['schema']['type'], $value['name'], $value['description'] ?? '')
                );
        });
    }

    private function buildMethodParameters(): void
    {
        $this->getParametersFromData()->each(function ($value) {
            $this->method->addParameter($value['name'], $value['schema']['default'] ?? null)
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
