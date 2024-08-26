<?php

$EM_CONF['jv_typoscript'] = [
    'title' => 'Allow to get TYPOSCRIPT Settiongs',
    'description' => 'Get Typscript from GIVEN Frontend request and answer as JSON. usefull in a cli command controller ',
    'category' => 'plugin',
    'author' => 'Joerg Velletti',
    'author_email' => 'typo3@velletti.de',
    'state' => 'beta',
    'version' => '0.0.8',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.1-12.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
