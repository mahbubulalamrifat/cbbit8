<?php

return [
    
    'pdf' => [
        'enabled' => true,
        'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf"',
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],
    
    'image' => [
        'enabled' => true,
        'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltoimage --viewport-size 1024x768"',
        'timeout' => false,
        'options' => [],
        'options' => array(
            //'page-size' => 'A4',
            //'margin-top' => 5,
            //'margin-right' => 5,
            //'margin-left' => 5,
            //'margin-bottom' => 6,
            //'orientation' => 'Landscape',
            //'footer-center' => 'Page [page] of [toPage]',
            //'footer-font-size' => 5,
            //'footer-left' => 'Confidential'
        ),
        'env'     => [],
    ],

];