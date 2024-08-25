<?php

use JVelletti\JvTyposcript\Middleware\Typoscript;
return [
    'frontend' => [
        'jvelletti/jv-typoscript/typoscript' => [
            'target' => Typoscript::class,
            'after' => [
                'typo3/cms-frontend/prepare-tsfe-rendering'
            ],
            'before' => [
                'typo3/cms-frontend/content-length-headers'
            ]
        ],
    ],
];
