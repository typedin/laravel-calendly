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

    public static function handle(string $uri, array $data): Method
    {
        $generator = new self($uri, $data);
        $generator->method
                  ->setVisibility('public')
                  ->setStatic(true)
                  ->setReturnType('Typedin\LaravelCalendly\Entities\ScheduledEvent\CalendlyScheduledEvent');

        $generator->buildMethodParameters();
        $generator->buildBody();
        $generator->buildDoc();

        return $generator->method;
    }

    private function buildMethodName(): string
    {
        return implode(explode(' ', $this->data['summary']));
    }

    private function getParametersFromData(): Collection
    {
        return collect($this->data['parameters'])->filter(fn ($value) => isset($value['name']));
    }

    private function buildMethodParameters(): void
    {
        $this->getParametersFromData()->each(function ($value) {
            $this->method->addParameter($value['name'])
                ->setType($value['schema']['type'] == 'integer' ? 'int' : $value['schema']['type'])
                ->setNullable(! isset($value['required']));
        });
    }

    private function buildBody(): void
    {
        $this->method
             ->addBody(sprintf('$response = BaseApiClient::get("%s");', $this->buildUri()))
             ->addBody('return new CalendlyScheduledEvent($response->json("resource"), "users")');
    }

   private function buildUri(): string
   {
       return str_replace_first('{uuid}', '{$uuid}', $this->uri);
   }

    private function buildDoc(): void
    {
        $this->method
                    ->addComment('\**')
                    ->addComment('* '.$this->data['summary'])
                    ->addComment('*');
        foreach ($this->data['parameters'] as $key => $value) {
            if (isset($value['name'])) {
                $this->method
                    ->addComment(
                        sprintf('* @param %s $%s %s', $value['schema']['type'], $value['name'], $value['description'] ?? '')
                    );
            }
        }
        $this->method->addComment('*/');
    }
}
