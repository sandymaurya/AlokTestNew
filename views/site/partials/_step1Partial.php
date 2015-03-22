<?php
    use \yii\helpers\Html;
    use app\helpers\HtmlHelper;
?>
<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-0">
    <div class="facts">
        <!-- Choose -->
        <div class="colors" id="order_ticketTime">
            <div class="dropdown-button">
                <?= Html::activeDropDownList($model, 'ticketTime', $model->getTimeList(), HtmlHelper::GetDropDownListOptions('Select Time')); ?>
                <?php echo Html::error($model, 'ticketTime', ['class' => 'help-block']);?>
            </div>
        </div>
        <div class="colors" id="order_ticketHotel">
            <div class="dropdown-button">
                <?= Html::activeDropDownList($model, 'ticketHotel', $model->getHotelsList(), HtmlHelper::GetDropDownListOptions('Hotel')); ?>
                <?php echo Html::error($model, 'ticketHotel', ['class' => 'help-block']);?>
            </div>
        </div>
        <div class="clearfix"></div>
        
        <div class="form-head" id="order_ticketQuantity">
            <div class="flat">
                <span class="user-icon"></span>
                <?= Html::activeTextInput($model, 'ticketQuantity', ['placeholder' => "Quantity","type"=>"number",'min'=>'1']); ?>
            </div>
            <?php echo Html::error($model, 'ticketQuantity', ['class' => 'help-block']);?>
        </div>
        <div class="form-head" id="order_ticketPromoCode">
            <div class="flat">
                <span class="promo"></span>
                <?= Html::activeTextInput($model, 'ticketPromoCode', ['placeholder' => "Promo Code"]); ?>
            </div>
            <?php echo Html::error($model, 'ticketPromoCode', ['class' => 'help-block']);?>
        </div>
        <div class="clearfix"></div>

        <div class="step-f">
            <button id="step1-submit" type="submit" name="submitOrderForm" value="Step1">Step 2</button>
            <button class="hide" id="moveTab2" type="button" name="submitOrderForm" value="Step1" role="tab" aria-controls="tab_item-1"></button>
        </div>
        <!-- Choose -->
    </div>
</div>