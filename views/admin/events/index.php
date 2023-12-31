<?php

use app\Entities\Events\Entities\Events;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\Entities\Events\Forms\EventSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $data */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Events', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_from',
                    'attribute2' => 'date_to',
                    'type' => DatePicker::TYPE_RANGE,
                    'separator' => '-',
                    'pluginOptions' => ['format' => 'yyyy-mm-dd']
                ]),
                'attribute' => 'date',
                'format' =>'date'
            ],
            [
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'managers',
                    'data' => $data,
                    'options' => ['placeholder' => 'Select a state ...']
                ]),
                'attribute' => 'managers',
                'format' =>'raw',
                'value' =>  function(Events $events) {
                    $managerArray = array_map(
                        function ($item) {
                            return sprintf('<p>%s</p>',$item->name);
                        },
                        $events->managers);
                    return implode($managerArray);
                }
            ],

            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete} {managers}',
                'urlCreator' => function ($action, Events $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'buttons' => [
                    'managers' => function ($url, $model) {
                        return Html::a(
                            '<i class="fas fa-user-tie"></i>',
                            $url
                        );
                    },
                ]
            ],
        ],
    ]); ?>


</div>
