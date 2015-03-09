<?php
    use \yii\helpers\Html;
    use app\helpers\HtmlHelper;
?>
<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-3">
    <div class="payment">
        <h4>Payment Options</h4>

        <div class="card" id="order_paymentOptionCardType">
            <p>Card Options</p>
            <?= $form->field($model, 'paymentOptionCardType',['template' => "{input}\n{error}"])->
            radioList($model->getPaymentOptionCardTypeList()); ?>
        </div>
        <div class="card cardy" id="order_paymentOptionCardHolderName">
            <?= $form->field($model, 'paymentOptionCardHolderName', ['inputOptions' => ["placeholder" => "Name"]])->label("Card Holder's Name"); ?>
        </div>
        <div class="card cardy" id="order_paymentOptionCardNumber">
            <?= $form->field($model, 'paymentOptionCardNumber', ['inputOptions' => ["placeholder" => "Number"]])->label("Card number"); ?>
        </div>
        <div class="clearfix"></div>
        <div class="card cardy">
            <p> Card Expiry Date </p>
            <span id="order_paymentOptionExpiryMonth">
                <?= Html::activeDropDownList($model, 'paymentOptionExpiryMonth', $model->getMonthNames(), HtmlHelper::GetDropDownListOptions('Month', 'month', false));?>
                <?php echo Html::error($model, 'paymentOptionExpiryMonth', ['class' => 'help-block']);?>
            </span>
            <span id="order_paymentOptionExpiryYear">
                <?= Html::activeDropDownList($model, 'paymentOptionExpiryYear', array_combine(range(date("Y"), date("Y") + 10), range(date("Y"), date("Y") + 10)), HtmlHelper::GetDropDownListOptions('Year', 'year', false));?>
                <?php echo Html::error($model, 'paymentOptionExpiryYear', ['class' => 'help-block']);?>
            </span>
        </div>
        <div class="card cardy" id="order_paymentOptionCVV">
            <?= $form->field($model, 'paymentOptionCVV', ['inputOptions' => ["placeholder" => "CVV"]])->label('Enter CVV Number'); ?>            
        </div>
        <div class="cleafix"></div>
        <br />
        <div class="step-d">
            <button class="btn btn-danger btn-lg" type="button" role="tab" aria-controls="tab_item-2">< Back</button>
            <button class="btn btn-danger btn-lg pull-right" id="step4-submit" type="submit" name="submitOrderForm" value="Step4">Buy</button>
        </div>
    </div>
</div>