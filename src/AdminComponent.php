<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 11.03.2017
 */
namespace skeeks\cms\admin;
use skeeks\cms\backend\BackendComponent;
use skeeks\cms\backend\BackendMenu;
use yii\base\Theme;
use yii\helpers\ArrayHelper;

/**
 * Class AdminComponent
 * @package skeeks\cms\admin
 */
class AdminComponent extends BackendComponent
{
    /**
     * @var string
     */
    public $controllerPrefix    = "admin";

    /**
     * @var array
     */
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
                    '@skeeks/cms/admin/views',
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
    
    

    /**
     * @return BackendMenu
     */
    public function getMenu()
    {
        if (is_array($this->_menu) || $this->_menu === null)
        {
            $data = (array) $this->_menu;
            
            if (!ArrayHelper::getValue($data, 'class'))
            {
                $data['class'] = BackendMenu::class;
            }
            
            if ($dataFromFiles = (array) $this->getMenuFilesData())
            {
                $dataFromFiles = static::_filesConfigNormalize($dataFromFiles);
            }

            if (ArrayHelper::getValue($data, 'data'))
            {
                $data['data'] = ArrayHelper::merge($dataFromFiles, $data['data']);
            } else
            {
                $data['data'] = $dataFromFiles;
            }

            if ($this->isMergeControllerMenu)
            {
                $data['data'] = ArrayHelper::merge((array) $this->getMenuDataFromControllers(), (array) $data['data']);
            }

            $this->_menu = \Yii::createObject($data);
        }

        return $this->_menu;
    }
    
    static protected function _filesConfigNormalize($config = [])
    {
        if ($config)
        {
            foreach ($config as $key => $itemData)
            {
                if ($label = ArrayHelper::getValue($itemData, 'label'))
                {
                    ArrayHelper::remove($itemData, 'label');
                    $itemData['name'] = $label;
                }

                if ($image = ArrayHelper::getValue($itemData, 'img'))
                {
                    ArrayHelper::remove($itemData, 'img');
                    $itemData['image'] = $image;
                }

                if ($code = ArrayHelper::getValue($itemData, 'code'))
                {
                    ArrayHelper::remove($itemData, 'code');
                    //$itemData['id'] = $code;
                }

                ArrayHelper::remove($itemData, 'enabled');

                if ($items = ArrayHelper::getValue($itemData, 'items'))
                {
                    if (is_array($items))
                    {
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

        if ($this->_menuFilesData !== null && is_array($this->_menuFilesData))
        {
            return (array) $this->_menuFilesData;
        }

        $paths[] = \Yii::getAlias('@common/config/admin/menu.php');
        $paths[] = \Yii::getAlias('@app/config/admin/menu.php');

        foreach (\Yii::$app->extensions as $code => $data)
        {
            if ($data['alias'])
            {
                foreach ($data['alias'] as $code => $path)
                {
                    $adminMenuFile = $path . '/config/admin/menu.php';
                    if (file_exists($adminMenuFile))
                    {
                        $menuGroups = (array) include_once $adminMenuFile;
                        $this->_menuFilesData = ArrayHelper::merge($this->_menuFilesData, $menuGroups);
                    }
                }
            }
        }

        foreach ($paths as $path)
        {
            if (file_exists($path))
            {
                $menuGroups = (array) include_once $path;
                $this->_menuFilesData = ArrayHelper::merge($this->_menuFilesData, $menuGroups);
            }
        }

        ArrayHelper::multisort($this->_menuFilesData, 'priority');

        if (!$this->_menuFilesData)
        {
            $this->_menuFilesData = false;
        }
        
        \Yii::endProfile('admin-menu');

        return (array) $this->_menuFilesData;
    }
}