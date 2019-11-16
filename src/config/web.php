<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */
return [
    'components' => [
        'admin' => [
            'class' => '\skeeks\cms\admin\components\AdminSettingsComponent'
        ],
    ],

    'modules' => [
        'admin' => [
            'class' => '\skeeks\cms\admin\AdminModule',
        ],
    ],
];