<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 12.03.2017
 */
namespace skeeks\cms\admin\controllers;

use Yii;
use yii\web\Controller;
/**
 * Class ErrorController
 * @package skeeks\cms\admin\controllers
 */
class ErrorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'skeeks\cms\admin\actions\ErrorAction',
            ],
        ];
    }

}
