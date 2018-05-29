<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\modules\gallery\models\Category;

/* @var $this yii\web\View */
/* @var $model backend\modules\gallery\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <?= Html::label($model->getAttributeLabel('pid'), '', ['class' => 'form-group col-sm-12']) ?>
    </div>
    <div class="row child_area">
        <?=
                $form->field($model, 'pid', ['options' => ['class' => 'form-group col-sm-3']])
                ->dropDownList(Category::getList(), ['prompt' => 'Select', 'size' => 4, 'class' => 'form-control pid-main'])
                ->label(false);
        ?>      

    </div>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'detail') ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php
$dataCate = json_encode(Category::getChild());
$pidInput = Html::getInputId($model, 'pid');
$pidName = Html::getInputName($model, 'pid');
//$urlAjax = Url::to('')
$js[] = <<< JS
   
    var dataTopic = $dataCate;
    var topic = 'topic';
    var selectVal = {};
    var subIndex = 0;
    console.log(dataTopic);
        var firstElement ;
    $(document).ready(function () {
        
        console.log(dataTopic);
        $('select#$pidInput').on('change', function () {
            var id = $(this).find('option:selected').val();
        //alert(id);
            if (id != "undefined") {
                $('.child_area .pid-sub').remove();
                $('#dynamic-form').empty();

                selectVal[$(this).attr('id')] = id;
                bindInput(id, subIndex);
            }
        });
    });

    function bindInput(id, subIndex) {
        //console.log(id);
        //alert(id);
        var child = getObjects(dataTopic, 'id', id);
        if (child['0'].sub) {
            console.log('child');
            var subData = child['0'].sub;
            console.log(subData);
            var tagId = topic + id;
            var tagDiv = $('<div class="form-group col-sm-3 field-category-pid pid-sub"></div>');
            var tagSelect = $('<select class="form-control" data-item="' + subIndex + '" size="4" id="' + tagId + '"></select>');
            //$(tagSelect).append('<option>— Select —</option>');
            $.each(subData, function (i, v) {
                option = $('<option></option>').val(v.id).text(v.title);
                $(tagSelect).append(option);
            });
            tagDiv = $(tagDiv).append(tagSelect);
            $('.child_area').append(tagDiv);

            $("#" + tagId).on('change click', function () {
                inputId = $(this).attr('id');

                changeInputName(inputId);
                var id = $(this).find('option:selected').val();
                sortArea($(this));
                bindInput(id, (subIndex + 1));
            });

        }
//        else {
//            console.log('callForm');
//            // alert(id);
//            callForm(id);
//        }
        console.log(selectVal);
        callForm(id);
    }

    function sortArea(input) {
        var sub = $(input).attr('data-item');
        $('.child_area select.sub').each(function (index) {
            if ($(this).attr('data-item') > sub) {
                $(this).remove();
            }
        });
    }

    function changeInputName(inputId) {
        $('select[name="$pidName"]').removeAttr('name');
        $('select#' + inputId).attr('name', '$pidName');
    }

    function getObjects(obj, key, val) {
        var objects = [];
        for (var i in obj) {
            if (!obj.hasOwnProperty(i))
                continue;
            if (typeof obj[i] == 'object') {
                objects = objects.concat(getObjects(obj[i], key, val));
            } else if (i == key && obj[key] == val) {
                objects.push(obj);
            }
        }
        return objects;
    }
    function loadInput(id) {
        console.log('loadInput:');
        console.log(id);
        $.get('respone-data.php',
                {
                    'topic_id': id
                },
                function (data) {
                    alert(data);
                    console.log(data);
                    if (!data) {
                        callForm(id);
                    }

                }
        );
    }

    function callForm(id) {
        console.log(id);
        var data = $(':input[name]', '#dynamic-form').serialize();
        $.ajax(
                'ajax.php/form/help-topic/' + id,
                {
                    data: data,
                    dataType: 'json',
                    success: function (json) {
                        $('#dynamic-form').empty().append(json.html);
                        $(document.head).append(json.media);
                    }
                });
    }
        
JS;

$this->registerJs(implode('\n', $js));



