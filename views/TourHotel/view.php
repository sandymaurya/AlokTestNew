<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TourHotel */

$this->title = $model->TourId;
$this->params['breadcrumbs'][] = ['label' => 'Tour Hotels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tour-hotel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'TourId' => $model->TourId, 'HotelId' => $model->HotelId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'TourId' => $model->TourId, 'HotelId' => $model->HotelId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'TourId',
            'HotelId',
        ],
    ]) ?>

</div>
