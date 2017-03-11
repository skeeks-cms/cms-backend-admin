<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright 2010 SkeekS
 * @date 08.03.2017
 */
return
[
    'bootstrap'     => ['backendAdmin'],
    'components'    =>
    [
        'backendAdmin' =>
        [
            'class'             => '\skeeks\cms\admin\AdminComponent',
            'controllerPrefix'  => 'admin',
            'urlRule'           => [
                'urlPrefix' => '~sx'
            ],
            /*'view' => [
                'theme' =>
                [
                    'pathMap'       =>
                    [
                        '@app/views' =>
                        [
                            '@app/templates/default',
                        ],
                    ]
                ],
            ],*/
        ],

        'i18n' => [
            'translations' =>
            [
                'skeeks/admin' => [
                    'class'             => 'yii\i18n\PhpMessageSource',
                    'basePath'          => '@skeeks/cms/admin/messages',
                    'fileMap' => [
                        'skeeks/admin' => 'main.php',
                    ],
                ]
            ]
        ]
    ],

    'modules' => [

        'admin' =>
        [
            'class' => '\skeeks\cms\admin\AdminModule'
        ],
    ],
];