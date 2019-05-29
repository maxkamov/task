<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Logo */
/* @var $form yii\widgets\ActiveForm */



?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>


    $(document).ready(function(){



        ///////////////////////////////////// Create picture //////////////////////////////////////////////////////////////////////////
        $("#add-picture").click(function(){

            $(".pictures").append(`
                <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group field-logo-image">
                                <input type="hidden" name="Logo[image][]" value=""><input type="file" id="logo-image" name="Logo[image][]" multiple="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-danger delete-picture">delete</button>
                    </div>
                 </div>
            `)
        });



    });

    /////////delete-picture///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $('body').on('click','.delete-picture',function(){
        $(this).parent().parent().remove();
    });
    /////////delete ///////////////////////////////////////////////////////////////////////////////////////////////////////////////





</script>













<div class="logo-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php

    $category = \yii\helpers\ArrayHelper::map(\app\models\Category::find()->asArray()->all(),'id','title');
    // Usage with ActiveForm and model
    echo $form->field($model, 'category_id')->widget(Select2::classname(), [
        'data' => $category,
        'options' => ['placeholder' => 'Select a category ...'],
        'pluginOptions' => [
        'allowClear' => true
        ],
    ]);

    ?>

    <?php

    $tags = \yii\helpers\ArrayHelper::map(\app\models\Tag::find()->asArray()->all(),'id','name');



    echo '<label class="control-label ">Tags</label>';
    echo Select2::widget([
        'name' => 'tags',
        'value' => $model->isNewRecord ? '' : $exist, // initial value (will be ordered accordingly and pushed to the top)
        'data' => $tags,
        'maintainOrder' => true,
        'options' => ['placeholder' => 'Select a tag ...', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 10
        ],
    ]);
    ?>


    <div class="pictures form-group">
        <label class="control-label " style="margin-top: 20px">Images</label>

        <?php if(!$model->isNewRecord){ ?>
            <?php foreach ($model->image as $img){ ?>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group field-logo-image">
                        <label><?= $img ?></label><input type="hidden" name="OldImage[]" value="<?= $img ?>">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-danger delete-picture">delete</button>
                </div>
            </div>
            <?php } ?>
        <?php } ?>

        <div class="row">
            <div class="col-sm-3">
                <div class="form-group field-logo-image">
                    <input type="hidden" name="Logo[image][]" value=""><input type="file" id="logo-image" name="Logo[image][]" multiple="">
                    <div class="help-block"></div>
                </div>
            </div>
            <div class="col-sm-4">
                <button type="button" class="btn btn-danger delete-picture">delete</button>
            </div>
        </div>
    </div>




    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <button id="add-picture" type="button" class="btn btn-warning">Add picture</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
