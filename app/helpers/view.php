<?php

function part(string $name): void
{
    include BASE_PATH . "/app/views/parts/{$name}.php";
}

function page(string $name): void
{
    include BASE_PATH . "/app/views/pages/{$name}.php";
}

function component(string $name): void
{
    include BASE_PATH . "/app/views/components/{$name}.php";
}