<?php

declare(strict_types=1);

return [
    'preset' => 'symfony',
    'ide' => 'phpstorm',
    'exclude' => [
        'vendor',
        'src/Shared',
    ],
    'add' => [],
    'remove' => [],
    'config' => [],
    'requirements' => [
        'min-quality' => 80,
        'min-complexity' => 80,
        'min-architecture' => 80,
        'min-style' => 80,
    ],
    'threads' => null,
];
