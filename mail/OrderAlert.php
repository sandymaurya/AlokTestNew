<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

//$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>

<p>Dear Admin,</p>
<p>This is confirmation mail from <?php echo \Yii::$app->params['sitename'] ?> for the order received with following details:</p>
<table>
    <thead>
        <tr>
            <th style="text-align: center; padding:5px 10px; min-width:100px; color:#ffffff; background:#333333;">Field</th>
            <th style="text-align: center; padding:5px 10px; min-width:100px; color:#ffffff; background:#333333;">Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center; padding:5px 10px; font-weight: bold; color:#ffffff; background:#777777;" colspan="2">
                <p>Ticket Details</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; background:#dddddd; color:#000; padding:3px;">Order</td>
            <td style="text-align: left; padding:5px 10px; background:#dddddd; color:#000; font-weight:bold;">
                <?php echo "Las Vegas Tour" ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; background:#dddddd; color:#000; padding:3px;">Hotel</td>
            <td style="text-align: left; padding:5px 10px; background:#dddddd; color:#000; font-weight:bold;"> 
                <?php echo app\models\Hotel::findOne(['Code'=>$data->attributes['ticketHotel']])->Name  ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; background:#dddddd; color:#000; padding:3px;">Booking Date</td>
            <td style="text-align: left; padding:5px 10px; background:#dddddd; color:#000; font-weight:bold;">
                <?php 
                    $arr = explode('-', $data->attributes['bookingDate']);
                    $date = new DateTime();
                    $date->setDate($arr[0],$arr[1],$arr[2]);
                    echo $date->format('d-M-Y');                
                ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; background:#dddddd; color:#000; padding:3px;">Time</td>
            <td style="text-align: left; padding:5px 10px; background:#dddddd; color:#000; font-weight:bold;">
                <?php echo str_replace('pm',' pm', str_replace('am', ' am', $data->attributes['ticketTime']))  ?>
            </td>
        </tr>        
        <tr>
            <td style="text-align: right; background:#dddddd; color:#000; padding:3px;">Quantity</td>
            <td style="text-align: left; padding:5px 10px; background:#dddddd; color:#000; font-weight:bold;">
                <?php echo $data->attributes['ticketQuantity'] ?>
            </td>
        </tr>        
        <tr>
            <td style="text-align: center; padding:5px 10px; font-weight: bold; color:#ffffff; background:#777777;" colspan="2">
                <p>Traveler Details</p>
            </td>
        </tr>        
        <tr>
            <td style="text-align: right; background:#dddddd; color:#000; padding:3px;">Traveler Type</td>
            <td style="text-align: left; padding:5px 10px; background:#dddddd; color:#000; font-weight:bold;">
                <?php echo \app\models\TravelerType::findOne(['Id'=>$data->attributes['travelerType']])->Type;  ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; background:#dddddd; color:#000; padding:3px;">Name</td>
            <td style="text-align: left; padding:5px 10px; background:#dddddd; color:#000; font-weight:bold;">
                <?php echo $data->attributes['travelerName'] ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; background:#dddddd; color:#000; padding:3px;">Address</td>
            <td style="text-align: left; padding:5px 10px; background:#dddddd; color:#000; font-weight:bold;">
                <?php echo $data->attributes['travelerAddress'] ?>
            </td>
        </tr>        
        <tr>
            <td style="text-align: right; background:#dddddd; color:#000; padding:3px;">DOB</td>
            <td style="text-align: left; padding:5px 10px; background:#dddddd; color:#000; font-weight:bold;">
                <?php echo $data->attributes['travelerDoBMonth'] . "-" . $data->attributes['travelerDoBYear'] ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; background:#dddddd; color:#000; padding:3px;">Email</td>
            <td style="text-align: left; padding:5px 10px; background:#dddddd; color:#000; font-weight:bold;">
                <?php echo $data->attributes['travelerEmail'] ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; background:#dddddd; color:#000; padding:3px;">Traveler Names</td>
            <td style="text-align: left; padding:5px 10px; background:#dddddd; color:#000; font-weight:bold;">
                <?php echo $data->attributes['travelerPersonNames'] ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding:5px 10px; font-weight: bold; color:#ffffff; background:#777777;" colspan="2">
                <p>Payment Details</p>
            </td>
        </tr>        
        <tr>
            <td style="text-align: right; background:#dddddd; color:#000; padding:3px;">Card Type</td>
            <td style="text-align: left; padding:5px 10px; background:#dddddd; color:#000; font-weight:bold;">
                <?php echo $data->attributes['paymentOptionCardType'] ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; background:#dddddd; color:#000; padding:3px;">Amount</td>
            <td style="text-align: left; padding:5px 10px; background:#dddddd; color:#000; font-weight:bold;">
                $99
            </td>
        </tr>
        <tr>
            <td style="text-align: right; background:#dddddd; color:#000; padding:3px;">Status</td>
            <td style="text-align: left; padding:5px 10px; background:#dddddd; color:#000; font-weight:bold;">
                Payment Received
            </td>
        </tr>                
    </tbody>
</table>

<p>Thanks</p>
<p><?php echo \Yii::$app->params['sitename'] ?> Team </p>
