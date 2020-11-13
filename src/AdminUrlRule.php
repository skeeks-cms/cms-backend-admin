<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\cms\admin;


use skeeks\cms\backend\BackendUrlRule;
use yii\helpers\ArrayHelper;
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class AdminUrlRule extends BackendUrlRule
{
    /**
     * @param \yii\web\UrlManager $manager
     * @param string              $route
     * @param array               $params
     * @return bool|string
     */
    public function createUrl($manager, $route, $params)
    {
        if (!isset($params['cms_site_id'])) {
            $params['cms_site_id'] = \Yii::$app->skeeks->site->id;
        }

        return parent::createUrl($manager, $route, $params);
    }

    /**
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request    $request
     * @return array|bool
     */
    public function parseRequest($manager, $request)
    {
        $params = $request->getQueryParams();
        if (isset($params['cms_site_id'])) {
            if ($params['cms_site_id'] != \Yii::$app->skeeks->site->id) {
                $class = \Yii::$app->skeeks->siteClass;
                \Yii::$app->skeeks->site = $class::findOne($params['cms_site_id']);
            }
        }
        return parent::parseRequest($manager, $request);
    }
}