<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\gallery\models\Gallery */

$this->title = 'Update Gallery: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Galleries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => (string) $model->_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gallery-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
        'modelPhoto' => $modelPhoto,
    ])
    ?>

</div>
