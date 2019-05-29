<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\LogoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Logos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Logo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'name',
            //'image',

            [
                'attribute'=>'name',
                'filter'=>false
            ],
            [
                'attribute'=>'category_id',
                'filter'=>false,
                'value' => function($data){
                    return $data->category->title;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>


</div>
