<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

namespace skeeks\cms\admin\widgets\auth;

use skeeks\cms\admin\widgets\auth\assets\AuthWidgetAsset;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Administration authorization widget.
 *
 * The authentication endpoints and state remain owned by skeeks/cms. This
 * widget owns only the admin guest-screen composition and client behavior.
 */
class AuthWidget extends Widget
{
    public $viewFile = 'auth';

    public $options = [];

    public $clientOptions = [];

    public $action = 'auth-by-phone';

    /** @var bool|null */
    public $is_allow_auth_by_email = null;

    /** @var bool|null */
    public $auth_submit_code_always = null;

    public function init()
    {
        Html::addCssClass($this->options, 'sx-auth-widget');
        $this->options['id'] = $this->id;

        if ($this->is_allow_auth_by_email === null) {
            $this->is_allow_auth_by_email = (int) \Yii::$app->cms->is_allow_auth_by_email;
        }
        if ($this->auth_submit_code_always === null) {
            $this->auth_submit_code_always = (int) \Yii::$app->cms->auth_submit_code_always;
        }

        $this->clientOptions['id'] = $this->id;
        $this->clientOptions['url-generate-callcheck-phone-code'] =
            Url::to(['/cms/auth/generate-callcheck-phone-code']);
        $this->clientOptions['url-generate-phone-code'] =
            Url::to(['/cms/auth/generate-phone-code']);
        $this->clientOptions['url-generate-email-code'] =
            Url::to(['/cms/auth/generate-email-code']);

        if (\Yii::$app->cms->smsProvider) {
            $this->action = 'auth-by-phone';
        } elseif (\Yii::$app->cms->callcheckProvider) {
            $this->action = 'auth-by-callcheck-phone';
        } else {
            $this->action = 'auth-by-email';
        }

        $this->clientOptions['action'] = $this->action;

        parent::init();
    }

    public function run()
    {
        AuthWidgetAsset::register($this->getView());

        return $this->render($this->viewFile, [
            'widget' => $this,
        ]);
    }
}
