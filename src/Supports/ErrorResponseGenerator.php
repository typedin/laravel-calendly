<?php

namespace Typedin\LaravelCalendly\Supports;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Typedin\LaravelCalendly\Supports\Configuration\BaseErrorResponseGeneratorProvider;

class ErrorResponseGenerator
{
    public readonly ClassType $error_response;

    private function __construct(private readonly BaseErrorResponseGeneratorProvider $provider)
    {
        $this->error_response = new ClassType(
            name: $this->errorResponseClassName(),
            namespace: new PhpNamespace('Typedin\LaravelCalendly\Http\Errors')
        );
    }

    public static function errorResponse(BaseErrorResponseGeneratorProvider $provider): ClassType
    {
        $error_response_generator = new ErrorResponseGenerator($provider);

        if (! $error_response_generator->isBaseClass()) {
            $error_response_generator->error_response->setExtends('\Typedin\LaravelCalendly\Http\Errors\ErrorResponse');
        }
        if ($error_response_generator->isBaseClass()) {
            $error_response_generator->generateConstructor()->generateProperties()->generateToJson();
        }

        $error_response_generator->error_response->validate();

        return $error_response_generator->error_response;
    }

    private function isBaseClass(): bool
    {
        return  $this->provider->returnType() == 'ErrorResponse';
    }

    private function errorResponseClassName(): string
    {
        return $this->isBaseClass() ? $this->provider->returnType() : $this->provider->returnType().'Error';
    }

    private function generateConstructor(): ErrorResponseGenerator
    {
        $this->error_response->addMethod('__construct');
        collect($this->provider->properties())->each(function ($property_value, $property_name) {
            $this->error_response
                    ->getMethod('__construct')
                    ->addParameter($property_name)
                    ->setNullable($this->provider->isNullable($property_name, $property_value))
                    ->setType(AppleSauce::getType($this->provider->properties()[$property_name]));

            $this->error_response->getMethod('__construct')->addBody(sprintf('$this->%s = $%s;', $property_name, $property_name));
        });

        return $this;
    }

    private function generateToJson(): ErrorResponseGenerator
    {
        $this->error_response->addMethod('toJson');
        $this->error_response
                ->getMethod('toJson')
                ->setReturnType("\Illuminate\Http\JsonResponse")

            ->addBody('return response()->json(["message" => $this->message, "title" => $this->title, "details" => $this->details], $this->error_code);');

        return $this;
    }

    private function generateProperties(): ErrorResponseGenerator
    {
        collect($this->provider->properties())->each(function ($property_value, $property_name) {
            $this->error_response
                    ->addProperty($property_name)
                    ->setType(AppleSauce::getType($this->provider->properties()[$property_name]))
                    ->setNullable($this->provider->isNullable($property_name, $property_value))
                    ->addComment($this->generatePropertieDescription($property_name))
                    ->addComment($this->generateVarComment($property_name));
        });

        return $this;
    }

    private function generatePropertieDescription(string $property): string
    {
        return $this->provider->properties()[$property]['description'] ?? '';
    }

    private function generateVarComment(string $property): string
    {
        $local_type = $this->provider->properties()[$property]['type'] ?? '';

        if (AppleSauce::isEnum($this->provider->properties()[$property]['type'])) {
            $enum = '<'.implode('|', $this->provider->properties()[$property]['enum']).'>';
            $local_type = $local_type.$enum;
        }

        return sprintf('@var %s $%s', $local_type, $property);
    }
}
