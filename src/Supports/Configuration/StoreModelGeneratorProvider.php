<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

use Illuminate\Support\Str;

class StoreModelGeneratorProvider extends ModelGeneratorProvider
{
    public function httpMethod(): string
    {
        return 'post';
    }

    public function returnType(): string
    {
        if (isset($this->value['post']['responses']['202'])) {
            throw new \TypeError(message: sprintf('Could get the return type for the path %s with post method. (%s)', $this->path, $this->name));
        }
        $ref = $this->value['post']['responses']['201']['content']['application/json']['schema']['properties']['resource']['$ref'] ??
                $this->value['post']['responses']['201']['content']['application/json']['schema']['properties']['resource'];
        if (is_array($ref)) {
            return 'Post'.Str::singular($this->name);
        }
        $lookup = explode('/', $ref);

        return end($lookup);
    }

    public function schema(): array
    {
        return $this->components['schemas'][$this->returnType()];
    }

    public function schemas(): array
    {
        return [];
    }
}
