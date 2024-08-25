<?php

use Jvelletti\JvTyposcript\Middleware\JvTyposcript;
return [
    'frontend' => [
        'jvelletti/jv-typoscript/typoscript' => [
            'target' => JvTyposcript::class,
            'after' => [
                'typo3/cms-frontend/prepare-tsfe-rendering'
            ],
            'before' => [
                'typo3/cms-frontend/content-length-headers'
            ]
        ],
    ],
];
