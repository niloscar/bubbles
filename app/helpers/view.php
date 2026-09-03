<?php

/**
 * View helper
 */

function part(string $name): void
{
    include BASE_PATH . "/app/views/parts/{$name}.php";
}

function page(string $name, array $data = []): void
{
    include BASE_PATH . "/app/views/pages/{$name}.php";
}

function component(string $name, array $data = []): void
{
    include BASE_PATH . "/app/views/components/{$name}.php";
}