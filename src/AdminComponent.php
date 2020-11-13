<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 11.03.2017
 */

namespace skeeks\cms\admin;

use skeeks\cms\admin\assets\AdminAsset;
use skeeks\cms\backend\BackendComponent;
use skeeks\cms\backend\BackendMenu;
use skeeks\cms\IHasPermissions;
use skeeks\cms\models\CmsSite;
use skeeks\cms\modules\admin\filters\AdminLastActivityAccessControl;
use skeeks\cms\rbac\CmsManager;
use skeeks\yii2\form\fields\SelectField;
use yii\base\Application;
use yii\base\Theme;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;

/**
 * Class AdminComponent
 * @package skeeks\cms\admin
 */
class AdminComponent extends BackendComponent
{
    /**
     * @var string
     */
    public $controllerPrefix = "admin";

    /**
     * @var string
     */
    public $accessControl = AdminAccessControl::class;

    /**
     * @var string
     */
    public $defaultRoute = "/admin/admin-index/index";

    /**
     * @var array
     */
    public $urlRule = [
        'urlPrefix' => '~sx',
    ];

    /**
     * Default pjax options
     *
     * @var array
     */
    public $pjax =
        [
            'timeout' => 30000,
        ];

    protected function _run()
    {
        //\Yii::$app->skeeks->setSite(CmsSite::findOne(1));

        \Yii::$app->errorHandler->errorAction = 'admin/error/error';

        $theme = new \skeeks\cms\themes\unify\admin\UnifyThemeAdmin();
        $theme->pathMap = [
            '@app/views' => [
                '@skeeks/cms/admin/views',
                '@skeeks/cms/themes/unify/admin/views',
                //'@skeeks/cms/admin/views',
            ],
        ];

        $theme->logoTitle = \Yii::$app->admin->logoTitle;
        if (\Yii::$app->admin->logoSrc) {
            $theme->logoSrc = \Yii::$app->admin->logoSrc;
        } else {
            if (\Yii::$app->skeeks->site && \Yii::$app->skeeks->site->image) {
                $theme->logoSrc = \Yii::$app->skeeks->site->image->src;
            }
        }
        $theme->logoHref = Url::to(['/admin/admin-index']);

        //$theme->favicon = "";
        \skeeks\cms\themes\unify\admin\UnifyThemeAdmin::initBeforeRender();
        \Yii::$app->view->theme = $theme;

        /*\Yii::$app->view->theme = new Theme([
            'pathMap' => [
                '@app/views' => [
                    //'@skeeks/crm/themes/unifyAdmin/views',
                    '@skeeks/cms/admin/views',
                ],
            ],
        ]);*/

        if ($this->pjax) {
            \Yii::$container->set('yii\widgets\Pjax', $this->pjax);
        }

        \Yii::$app->language = \Yii::$app->admin->languageCode;

        /*\Yii::$container->setDefinitions([
            BackendController::class => \skeeks\modules\cms\form2\controllers\BackendController::class
        ]);*/

        \Yii::$app->on(Application::EVENT_BEFORE_ACTION, function () {
            if (in_array(\Yii::$app->controller->uniqueId, [
                'admin/admin-auth',
            ])) {
                return true;
            }

            if ($behaviorAccess = ArrayHelper::getValue(\Yii::$app->controller->behaviors(), 'access')) {
                $behaviorAccess['class'] = \skeeks\cms\admin\AdminAccessControl::class;
                \Yii::$app->controller->detachBehavior('access');
                \Yii::$app->controller->attachBehavior('access', $behaviorAccess);
            }

            \Yii::$app->controller->attachBehavior('adminLastActivityAccess', [
                'class' => AdminLastActivityAccessControl::className(),
                'rules' =>
                    [
                        [
                            'allow'         => true,
                            'matchCallback' => function ($rule, $action) {
                                if (\Yii::$app->user->identity->lastAdminActivityAgo > \Yii::$app->admin->blockedTime) {
                                    return false;
                                }

                                if (\Yii::$app->user->identity) {
                                    \Yii::$app->user->identity->updateLastAdminActivity();
                                }

                                return true;
                            },
                        ],
                    ],
            ]);

            if (\Yii::$app->controller instanceof IHasPermissions && \Yii::$app->controller->permissionNames) {
                $result = ArrayHelper::merge([
                    CmsManager::PERMISSION_ADMIN_ACCESS => \Yii::t('skeeks/cms', 'Access to the administration system'),
                ], \Yii::$app->controller->permissionNames);

                \Yii::$app->controller->setPermissionNames($result);
            }

            //Для работы с системой управления сайтом, будем требовать от пользователя реальные данные
            if (\Yii::$app->user->isGuest === false) {
                if (!in_array(\Yii::$app->controller->uniqueId, [
                    'admin/error',
                    'cms/admin-profile',
                ])) {
                //if (\Yii::$app->controller->uniqueId != 'cms/admin-profile') {
                    /*var_dump(\Yii::$app->controller->uniqueId);
                    die();*/
                    $user = \Yii::$app->user->identity;
                    if (!$user->email || !$user->first_name || !$user->last_name || !$user->image) {
                        \Yii::$app->response->redirect(Url::to(['/cms/admin-profile/update']));
                    }
                }
            }
            
        });

        \Yii::$container->setDefinitions(ArrayHelper::merge(
            \Yii::$container->definitions,
            [
                /*SelectField::class => [
                    'class' => AdminSelectField::class,
                ],*/
            ]
        ));
        parent::_run();
    }


    /**
     * @return BackendMenu
     */
    public function getMenu()
    {
        if (is_array($this->_menu) || $this->_menu === null) {
            $data = (array)$this->_menu;

            if (!ArrayHelper::getValue($data, 'class')) {
                $data['class'] = BackendMenu::class;
            }

            if ($dataFromFiles = (array)$this->getMenuFilesData()) {
                $dataFromFiles = static::_filesConfigNormalize($dataFromFiles);
            }

            if (ArrayHelper::getValue($data, 'data')) {
                $data['data'] = ArrayHelper::merge($dataFromFiles, $data['data']);
            } else {
                $data['data'] = $dataFromFiles;
            }

            if ($this->isMergeControllerMenu) {
                $data['data'] = ArrayHelper::merge((array)$this->getMenuDataFromControllers(), (array)$data['data']);
            }

            $this->_menu = \Yii::createObject($data);
        }

        return $this->_menu;
    }

    static protected function _filesConfigNormalize($config = [])
    {
        if ($config) {
            foreach ($config as $key => $itemData) {
                if ($label = ArrayHelper::getValue($itemData, 'label')) {
                    ArrayHelper::remove($itemData, 'label');
                    $itemData['name'] = $label;
                }

                if ($image = ArrayHelper::getValue($itemData, 'img')) {
                    ArrayHelper::remove($itemData, 'img');
                    $itemData['image'] = $image;
                }

                if ($code = ArrayHelper::getValue($itemData, 'code')) {
                    ArrayHelper::remove($itemData, 'code');
                    //$itemData['id'] = $code;
                }

                ArrayHelper::remove($itemData, 'enabled');

                if ($items = ArrayHelper::getValue($itemData, 'items')) {
                    if (is_array($items)) {
                        $itemData['items'] = self::_filesConfigNormalize($items);
                    }
                }

                $config[$key] = $itemData;
            }
        }

        return $config;
    }

    protected $_menuFilesData = null;

    /**
     * Scan admin config files
     * @return array
     */
    public function getMenuFilesData()
    {
        \Yii::beginProfile('admin-menu');

        if ($this->_menuFilesData !== null && is_array($this->_menuFilesData)) {
            return (array)$this->_menuFilesData;
        }

        $paths[] = \Yii::getAlias('@common/config/admin/menu.php');
        $paths[] = \Yii::getAlias('@app/config/admin/menu.php');

        foreach (\Yii::$app->extensions as $code => $data) {
            if ($data['alias']) {
                foreach ($data['alias'] as $code => $path) {
                    $adminMenuFile = $path.'/config/admin/menu.php';
                    if (file_exists($adminMenuFile)) {
                        $menuGroups = (array)include_once $adminMenuFile;
                        $this->_menuFilesData = ArrayHelper::merge($this->_menuFilesData, $menuGroups);
                    }
                }
            }
        }

        foreach ($paths as $path) {
            if (file_exists($path)) {
                $menuGroups = (array)include_once $path;
                $this->_menuFilesData = ArrayHelper::merge($this->_menuFilesData, $menuGroups);
            }
        }

        ArrayHelper::multisort($this->_menuFilesData, 'priority');

        if (!$this->_menuFilesData) {
            $this->_menuFilesData = false;
        }

        \Yii::endProfile('admin-menu');

        return (array)$this->_menuFilesData;
    }


    /**
     * @param View|null $view
     */
    public function initJs(View $view = null)
    {
        $options =
            [
                'BlockerImageLoader' => AdminAsset::getAssetUrl('images/loaders/circulare-blue-24_24.GIF'),
                'disableCetainLink'  => false,
                'globalAjaxLoader'   => true,
                'menu'               => [],
            ];

        $options = \yii\helpers\Json::encode($options);

        \Yii::$app->view->registerJs(<<<JS
        (function(sx, $, _)
        {
            /**
            * @type {Admin}
            */
            sx.App = new sx.classes.Admin($options);

        })(sx, sx.$, sx._);
JS
        );
    }

}