<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 30.09.2015
 */

namespace skeeks\cms\admin\widgets;

use skeeks\cms\admin\assets\AdminPanelAsset;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class AdminPanelWidget
 * @package skeeks\cms\admin\widgets
 */
class AdminPanelWidget extends Widget
{
    /**
     * Widget options
     *
     *  'class' => 'sx-dashboard-widget',
     * 'data'      =>
     * [
     * 'id' => 1
     * ],
     * @var array
     */
    public $options = [];


    /**
     * Widget color scheme
     *
     * panel-primary
     * panel-success
     * panel-danger
     *
     * @var string
     */
    public $color = 'panel-primary';

    /**
     * Panel heading options
     *
     * @var array
     */
    public $headingOptions = [
        'class' => 'panel-heading card-header sx-admin-panel__header sx-panel__header sx-panel__header--bordered',
    ];


    /**
     * Panel body options
     *
     * @var array
     */
    public $bodyOptions = [
        'class' => 'panel-body sx-panel__body'
    ];

    /**
     * @var array Footer container options.
     */
    public $footerOptions = [
        'class' => 'panel-footer card-footer sx-panel__footer',
    ];


    /**
     * @var Название панели
     */
    public $name;
    /**
     * @var Содержимое
     */
    public $content;

    /**
     * @var Кнопки действий
     */
    public $actions;

    /**
     * Optional panel footer. Kept outside the streamed body content.
     *
     * @var string|null
     */
    public $footer;

    /**
     * Initializes the widget.
     * This renders the form open tag.
     */
    public function init()
    {
        Html::addCssClass($this->options, ['panel', 'sx-panel', 'sx-panel--responsive', $this->color]);
        AdminPanelAsset::register($this->view);
        Html::addCssClass($this->options, ['card', 'sx-admin-panel']);

        $options = ArrayHelper::merge($this->options, [
            'id' => $this->id,
        ]);

        echo Html::beginTag('div', $options);

        echo Html::beginTag('div', $this->headingOptions);

        echo <<<HTML
                <h3 class="text-uppercase sx-admin-panel__title sx-panel__title mb-0">
                    {$this->name}
                </h3>
                <div class="panel-actions panel-hidden-actions sx-panel__actions">
                    {$this->actions}
                </div>
HTML;

        echo Html::endTag('div');

        echo Html::beginTag('div', $this->bodyOptions);

        //echo '<div class="panel-content">' . $this->content;
        echo $this->content;

    }

    /**
     * Runs the widget.
     * This registers the necessary javascript code and renders the form close tag.
     * @throws InvalidCallException if `beginField()` and `endField()` calls are not matching
     */
    public function run()
    {
        echo Html::endTag('div');

        if ($this->footer !== null && $this->footer !== '') {
            echo Html::tag('div', $this->footer, $this->footerOptions);
        }

        echo Html::endTag('div');

        self::registerJs();
    }

    static protected $_isRegisteredJs = null;

    static public function registerJs()
    {
        if (self::$_isRegisteredJs === true) {
            return false;
        }

        self::$_isRegisteredJs = true;

        \Yii::$app->view->registerJs(<<<JS
        $(".sx-btn-trigger-full").on('click', function()
        {
            var panel = $(this).closest('.sx-panel');
            if (panel.hasClass('sx-panel-full'))
            {
                 panel.removeClass('sx-panel-full');
            } else
            {
                panel.addClass('sx-panel-full');
            }

            return false;
        });
JS
        );
    }
}
