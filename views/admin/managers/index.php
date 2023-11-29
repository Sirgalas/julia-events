<?php

use app\Entities\Managers\Entities\Managers;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\Entities\Managers\Forms\ManagerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $data */

$this->title = 'Managers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="managers-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Managers', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'email:email',
            'phone',
            [
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'events',
                    'data' => $data,
                    'options' => ['placeholder' => 'Select a state ...']
                ]),
                'attribute' => 'managers',
                'format' =>'raw',
                'value' =>  function(Managers $managers) {
                    $managerArray = array_map(
                        function ($item) {
                            return sprintf('<p>%s</p>',$item->name);
                        },
                        $managers->events);
                    return implode($managerArray);
                }
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete} {events}',
                'urlCreator' => function ($action, Managers $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'buttons' => [
                    'events' => function ($url, $model) {
                        return Html::a(
                            '<i class="fas fa-umbrella-beach"></i>',
                            $url
                        );
                    },
                ]
            ],
        ],
    ]); ?>


</div>
