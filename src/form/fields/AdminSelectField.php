<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 11.03.2017
 */

namespace skeeks\cms\admin\form\fields;

use skeeks\widget\chosen\Chosen;
use skeeks\yii2\form\fields\SelectField;
use yii\helpers\ArrayHelper;
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class AdminSelectField extends SelectField
{
    public $widgetConfig = [];

    public function getActiveField()
    {
        $field = parent::getActiveField();

        if ($this->multiple) {
            $this->elementOptions['multiple'] = $this->multiple;
        }

        if (!$this->multiple && !isset($this->elementOptions['size'])) {
            $this->elementOptions['size'] = 1;
        }

        $items = $this->getItems();
        ArrayHelper::remove($items, null);

        $resultOptions = ArrayHelper::merge([
            'items'         => $items,
            'clientOptions' => [
                'search_contains' => true,
            ],
            'multiple'      => $this->multiple,
            'options'       => $this->elementOptions,
        ], $this->widgetConfig);

        
        $field->widget(
            Chosen::class,
            $resultOptions
        );

        return $field;
    }
}