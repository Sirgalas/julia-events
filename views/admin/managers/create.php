<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\Entities\Managers\Entities\Managers $model */

$this->title = 'Create Managers';
$this->params['breadcrumbs'][] = ['label' => 'Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="managers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
