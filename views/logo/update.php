<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Logo */

$this->title = 'Update Logo: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Logos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="logo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'exist' => $exist
    ]) ?>

</div>
