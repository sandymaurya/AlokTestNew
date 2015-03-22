<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TourHotel */

$this->title = 'Update Tour Hotel: ' . ' ' . $model->TourId;
$this->params['breadcrumbs'][] = ['label' => 'Tour Hotels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TourId, 'url' => ['view', 'TourId' => $model->TourId, 'HotelId' => $model->HotelId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tour-hotel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
