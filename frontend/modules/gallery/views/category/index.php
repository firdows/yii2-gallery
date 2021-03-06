<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\gallery\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Categories';
$this->title = Yii::$app->request->get('pid') ? 'Sub Category' : 'Categories';
$this->params['breadcrumbs'][] = $this->title ;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list_item',
    ]);
    ?>
</div>
