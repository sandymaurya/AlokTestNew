<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TourHotel */

$this->title = 'Create Tour Hotel';
$this->params['breadcrumbs'][] = ['label' => 'Tour Hotels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tour-hotel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
