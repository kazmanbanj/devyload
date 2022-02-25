<?php

function create($class, $attributes = [])
{
    return factory($class)->create($attribute);
}

function make($class, $attributes = [])
{
    return factory($class)->make($attribute);
}