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
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class AdminSelectField extends SelectField
{
    public function getActiveField()
    {
        $field = parent::getActiveField();

        if ($this->multiple) {
            $this->elementOptions['multiple'] = $this->multiple;
        }

        if (!$this->multiple && !isset($this->elementOptions['size'])) {
            $this->elementOptions['size'] = 1;
        }

        return $field->widget(
            Chosen::class,
            [
                'items' => $this->getItems(),
                'clientOptions' =>
                [
                    'search_contains' => true
                ]
            ]
        );

        return $field;
    }
}