<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 30.09.2015
 */

namespace skeeks\cms\admin\widgets;

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
        'class' => 'panel-heading card-header g-brd-bottom-none g-px-15 g-px-30--sm g-pt-15 g-pt-20--sm g-pb-10 g-pb-15--sm'
    ];


    /**
     * Panel body options
     *
     * @var array
     */
    public $bodyOptions = [
        'class' => 'panel-body'
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
     * Initializes the widget.
     * This renders the form open tag.
     */
    public function init()
    {
        Html::addCssClass($this->options, ['panel', 'sx-panel', $this->color]);
        Html::addCssClass($this->options, ['card', 'g-brd-gray-light-v7', 'g-rounded-3', 'g-mb-20']);

        $options = ArrayHelper::merge($this->options, [
            'id' => $this->id,
        ]);

        echo Html::beginTag('div', $options);

        echo Html::beginTag('div', $this->headingOptions);

        echo <<<HTML

                <div class="media">
                    <h3 class="d-flex align-self-center text-uppercase g-font-size-12 g-font-size-default--md g-color-black g-mr-10 mb-0">
                        {$this->name}
                    </h3>
                    <div class="panel-actions panel-hidden-actions media-body d-flex justify-content-end">
                        {$this->actions}
                    </div>
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

        \Yii::$app->view->registerCss(<<<CSS

.sx-panel-full
{
    position: fixed;
    top: 0;
    left: 0;
    z-index: 10000;
    width: 100%;
    height: 100%;
    overflow: auto;
}


CSS
        );

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