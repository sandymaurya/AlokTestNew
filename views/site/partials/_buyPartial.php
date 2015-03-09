<?php
    use yii\widgets\ActiveForm;
    use ruskid\stripe\StripeCheckout;
?>
<div class="col-md-8 buy-g-col">
    <!--Tabs -->
    <div class="sap_tabs">
        <div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
            <ul class="resp-tabs-list">
                <li class="resp-tab-item disabled" onclick="return false;">
                    <span>Step 1: Tickets</span>
                </li>
                <li class="resp-tab-item disabled" onclick="return false;">
                    <span>Step 2: Select Date</span></li>
                <li class="resp-tab-item disabled" onclick="return false;">
                    <span>Step 3: Traveler's info</span>
                </li>
                <li class="resp-tab-item disabled" onclick="return false;">
                    <span>Step 4: Payment</span>
                </li>
                <div class="clearfix"></div>
            </ul>

            <?php $form = ActiveForm::begin([
                'id' => 'frmBookTicket',
                'action' => 'order/process'
            ]); ?>
            <div class="resp-tabs-container">
                <?php echo $this->render('_step1Partial', ['model' => $model, 'form'=>$form]); ?>
                <?php echo $this->render('_step2Partial', ['model' => $model, 'form'=>$form]); ?>
                <?php echo $this->render('_step3Partial', ['model' => $model, 'form'=>$form]); ?>
                <?php echo $this->render('_step4Partial', ['model' => $model, 'form'=>$form]); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>