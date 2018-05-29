<?php

namespace backend\modules\gallery;

/**
 * gallery module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\gallery\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        $this->layout = 'tab';
        parent::init();

        // custom initialization code goes here
    }

}
