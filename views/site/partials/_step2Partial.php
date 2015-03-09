<?php
    use \yii\helpers\Html;
    use app\helpers\HtmlHelper;
?>
<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-1">
    <div class="delivery" id="order_bookingDate">
        <h4>Select Booking Date of Tour</h4>
        <?php
        echo Html::activeDropDownList($model,'bookingDay', array_combine(range(1, 31), range(1, 31)), HtmlHelper::GetDropDownListOptions('Date', 'date', false));
        echo Html::activeDropDownList($model, 'bookingMonth',$model->getMonthNames(), HtmlHelper::GetDropDownListOptions('Month', 'month', false));
        echo Html::activeDropDownList($model, 'bookingYear',array_combine(range(date("Y"), date("Y") + 2), range(date("Y"), date("Y") + 2)), HtmlHelper::GetDropDownListOptions('Year', 'year', false));
        ?>
        <?= Html::activeHiddenInput($model, 'bookingDate'); ?>
        <?php echo Html::error($model, 'bookingDate', ['class' => 'help-block']);?>
<!--        <div id="order_bookingDay">-->
<!--            --><?php
//                echo $form->field($model, 'bookingDay')   ->
//                dropDownList(range(1, 30), HtmlHelper::GetDropDownListOptions('Date', 'date', false));
//            ?>
<!--        </div>-->
<!--        <div id="order_bookingMonth">-->
<!--            --><?php
//                echo $form->field($model, 'bookingMonth')->
//                dropDownList($model->getMonthNames(), HtmlHelper::GetDropDownListOptions('Month', 'month', false));
//            ?>
<!--        </div>-->
<!--        <div id="order_bookingYear">-->
<!--            --><?php
//                echo $form->field($model, 'bookingYear')->
//                dropDownList(range(date("Y"), date("Y") + 5), HtmlHelper::GetDropDownListOptions('Year', 'year', false));
//            ?>
<!--        </div>-->
    </div>
    <div class="clearfix"></div>

    <div class="delivery-ad" id="order_bookingSpecialNeeds">
        <h4>Special Needs / Handicap / Honeymon / Large Groups</h4>
        <?= Html::activeTextarea($model, 'bookingSpecialNeeds',['placeholder' => "Basic info & Questions"]); ?>
        <?php echo Html::error($model, 'bookingSpecialNeeds', ['class' => 'help-block']);?>
    </div>
    <div class="step-f step-e">
        <button class="btn btn-danger btn-lg pull-left" type="button" role="tab" aria-controls="tab_item-0">< Back</button>
        <button id="step2-submit" type="submit" name="submitOrderForm" value="Step2">Step 3</button>
        <button class="hide" id="moveTab3" type="button" name="submitOrderForm" value="Step1" role="tab" aria-controls="tab_item-2"></button>
    </div>
</div>