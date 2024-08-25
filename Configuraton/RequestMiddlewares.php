<?php

use JVelletti\JvTemplate\Middleware\Template;
return [
    'frontend' => [
        'jvelletti/jvtemplate/template' => [
            'target' => Template::class,
            'after' => [
                'typo3/cms-frontend/content-length-headers'
            ],
        ],
    ],
];
