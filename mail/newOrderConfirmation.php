<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

//$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>

<p>Dear Admin,</p>
<p>This is confirmation mail from <?php echo \Yii::$app->params['sitename']?> for the order received with following details:</p>
<table>
<tbody>
<tr>
<td style="width: 100px;">
<p>Ticket Details:</p>
</td>
<td>
	Time: <?php echo $data->attributes['ticketTime']?><br />
	Hotel: <?php echo $data->attributes['ticketHotel']?><br />
	Quantity: <?php echo $data->attributes['ticketQuantity']?><br />
	Booking Date: <?php echo $data->attributes['bookingDate']?><br />
</td>
</tr>
<tr>
<td style="width: 100px;">
<p>Traveler Details:</p>
</td>
<td>
	Traveler Type: <?php echo $data->attributes['travelerType']?><br />
	Name: <?php echo $data->attributes['travelerName']?><br />
	Address: <?php echo $data->attributes['travelerAddress']?><br />
	DOB: <?php echo $data->attributes['travelerDoBMonth']."-".$data->attributes['travelerDoBYear']?><br />
	Email: <?php echo $data->attributes['travelerEmail']?><br />
	Traveler Names: <?php echo $data->attributes['travelerPersonNames']?><br />
</td>
</tr>
<tr>
<td style="width: 100px;">
<p>Payment Details:</p>
</td>
<td>
	Card Type: <?php echo $data->attributes['paymentOptionCardType']?><br />
	Amount: <?php echo "99"?><br />
	Status: <?php echo "Payment Confirmed"?><br />
</td>
</tr>
</tbody>
</table>

<p>Thanks</p>
<p><?php echo \Yii::$app->params['sitename']?> Team </p>
