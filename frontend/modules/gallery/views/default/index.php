<?php

use yii\widgets\ListView;

$this->title = 'Galleries';
$this->params['breadcrumbs'][] = $this->title;
?>






<div class="row">
    <div class="col-sm-12">
        <?= $this->render('_search', ['model' => $searchModel]) ?>
    </div>
</div>
<div class="row">
    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list_item',
    ]);
    ?>
</div>

