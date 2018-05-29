<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

$module = $this->context->module->id;
$controller = $this->context->id;
$action = $this->context->action->id;
//$moCon = $module . '/' . $controller;
$moCon = $module;
$chkRoute = $controller;



$items[] = [
    'label' => '<i class="fa fa-medkit"></i> Gallery',
    'url' => ["/{$moCon}/default"]
];
$items[] = [
    'label' => '<i class="fa fa-medkit"></i> Category',
    'url' => ["/{$moCon}/category"]
];



//echo $chkRoute;
foreach ($items as $key => $item) {
    if (isset($item['url'][0]))
        $items[$key]['active'] = strrpos($item['url'][0], $chkRoute);
}
?>

<?php

//NavBar::begin(['brandLabel' => Html::a('บันทึกการรักษาย้อนหลัง', ['#'], ['class' => 'btn btn-success navbar-btn navbar-left'])]);
//echo Html::a('บันทึกการรักษาย้อนหลัง', ['#'], ['class' => 'btn btn-success navbar-btn navbar-left'])." ";
echo Nav::widget(
        [
            'options' => ['class' => 'nav nav-tabs', 'style' => 'background:#ccc;'],
            'items' => $items,
            'encodeLabels' => false,
        ]
);
//NavBar::end();
?>
