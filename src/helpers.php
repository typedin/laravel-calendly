<?php

if (! function_exists('clone_array')) {
    function clone_array($arr)
    {
        $clone = [];
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                $clone[$k] = clone_array($v);
            } //If a subarray
            elseif (is_object($v)) {
                $clone[$k] = clone $v;
            } //If an object
            else {
                $clone[$k] = $v;
            } //Other primitive types.
        }

        return $clone;
    }
}
