<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Typedin\LaravelCalendly\Supports\Generator;

class GeneratorTest extends TestCase
{
    protected static $data;

    public static function setUpBeforeClass(): void
    {
        $paths = array_slice(Yaml::parse(file_get_contents(__DIR__.'/../../doc/openapi.yaml'))['paths'], 0);
        $paths = Yaml::parse(file_get_contents(__DIR__.'/../../doc/openapi.yaml'))['paths'];

        self::$data = collect();
        foreach ($paths as $key => $value) {
            $uri = $key;
            //remove the parameters key
            $one = array_keys($value);
            if (($key = array_search('parameters', $one)) !== false) {
                unset($one[$key]);
            }

            $name = $value[array_values($one)[0]]['tags'][0];
            self::$data->push(
                collect([
                    'uri' => $uri,
                    'name' => $name,
                    'methods' => $value,
                ])
            );
        }
    }

    /** @test */
    public function it_does_all_the_things(): void
    {
        $result = (new Generator(self::$data->first()))->build();
        $content = $result['content'];
        $file_path = sprintf('/../../src/Api/%s.php', $result['file_name']);

        file_put_contents(__DIR__.$file_path, $content);

        dd($result['content']);
    }
}
