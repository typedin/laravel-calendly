<?php

namespace Typedin\LaravelCalendly\traits;

trait UseCrudVerbs
{
    public $CRUD_OPERATIONS = [
        'index' => 'Index',
        'get' => 'Show',
        'post' => 'Store',
        'delete' => 'Destroy',
    ];
}
