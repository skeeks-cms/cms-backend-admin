<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 11.03.2017
 */
namespace skeeks\cms\admin;
use skeeks\cms\backend\BackendComponent;
use yii\base\Theme;

/**
 * Class AdminComponent
 * @package skeeks\cms\admin
 */
class AdminComponent extends BackendComponent
{
    public $controllerPrefix    = "admin";

    public $urlRule             = [
        'urlPrefix' => '~sx'
    ];

    /**
     * Default pjax options
     *
     * @var array
     */
    public $pjax                        =
    [
        'timeout' => 30000
    ];

    public function run()
    {
        \Yii::$app->errorHandler->errorAction = 'admin/error/error';

        \Yii::$app->view->theme = new Theme([
            'pathMap' =>
            [
                '@app/views' =>
                [
                    '@skeeks/cms/modules/admin/views',
                ]
            ]
        ]);

        if ($this->pjax)
        {
            \Yii::$container->set('yii\widgets\Pjax', $this->pjax);
        }

        \Yii::$app->language = \Yii::$app->admin->languageCode;

        parent::run();
    }
}