<?php

use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\Entities\Managers\Forms\EventsForm $model */
/** @var array $data */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'date',
        ],
    ]); ?>
    <div class="events-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'event_id')->widget(Select2::class, [
                'data' => $data,
                'options' => ['placeholder' => 'Select a state ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ] );
        ?>


        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>