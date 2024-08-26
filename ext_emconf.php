<?php

$EM_CONF['jv_typoscript'] = [
    'title' => 'Allow to get TYPOSCRIPT Settings',
    'description' => 'Get Typscript from Frontend CURL request and answer as JSON. usefull in a cli command controller ',
    'category' => 'plugin',
    'author' => 'Joerg Velletti',
    'author_email' => 'typo3@velletti.de',
    'state' => 'beta',
    'version' => '0.0.8',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.1-12.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
