<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\LogoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="logo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'tag_name') ?>
        </div>
        <div class="col-md-4">
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
        </div>
    </div>




    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
