<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

//$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>

<p>Dear <?php echo $data->attributes['travelerName'] ?>,</p>
<?php echo $this->render("infoTable",['data'=>$data])?>
<br />
<br />
<span style="font-size: 0.8em; color:#999999;">For any query or suggestion please contact sales@anniebananies.com</span>