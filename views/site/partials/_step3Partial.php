<?php
use \yii\helpers\Html;
use app\helpers\HtmlHelper;

?>
<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-2">
    <div class="payment">
        <h4>Traveler's Information </h4>

        <div class="card" id="order_travelerType">
            <?= $form->field($model, 'travelerType', ['template' => "{label}\n{input}\n{error}"])->radioList($model->getTravelerTypeList())->label("Who is traveling"); ?>
        </div>
        <div class="card cardy" id="order_travelerName">
            <?= $form->field($model, 'travelerName', ['inputOptions' => ['placeholder' => 'Name']])->label("Traveler's Name"); ?>
        </div>

        <div class="card cardy" id="order_travelerAddress">
            <?= $form->field($model, 'travelerAddress', ['inputOptions' => ['placeholder' => 'Home Address']])->label("Home Address"); ?>
        </div>
        <div class="clearfix"></div>
        <div class="card cardy">
            <p>Date of Birth</p>
            <div id="order_travelerDoBMonth">
                <?php
                    echo Html::activeDropDownList($model, 'travelerDoBMonth',$model->getMonthNames(), HtmlHelper::GetDropDownListOptions('Month', 'month', false));
                ?>
                <?php echo Html::error($model, 'travelerDOBMonth', ['class' => 'help-block']);?>
            </div>
            <div id="order_travelerDoBYear">
                <?php
                    echo Html::activeDropDownList($model, 'travelerDoBYear', array_combine(range(date("Y")-5,date("Y")-100,-1), range(date("Y")-5,date("Y")-100,-1)), HtmlHelper::GetDropDownListOptions('Year', 'year', false));
                ?>
                <?php echo Html::error($model, 'travelerDoBYear', ['class' => 'help-block']);?>
            </div>
        </div>
        <div class="card cardy" id="order_travelerEmail">
            <?php
            echo $form->field($model, 'travelerEmail')->textInput(['placeholder'=>'example@email.com'])->label('Enter eMail Address');
            ?>
        </div>
        <br />
        <div class="deliver-ad" id="order_travelerPersonNames">
            <h4>If You Checked Family, Add Family Names Below</h4>
            <?php
            echo $form->field($model, 'travelerPersonNames',['template'=>"{input}\n{error}"])->textarea(['placeholder'=>'Name1, Name2, Child Name1']);
            ?>
        </div>
        <div class="cleafix"></div>
        <div class="step-f">
            <button class="btn btn-danger btn-lg pull-left" type="button" role="tab" aria-controls="tab_item-1">< Back</button>
            <button id="step3-submit" type="submit" name="submitOrderForm" value="Step3">Step 4</button>
            <button class="hide" id="moveTab4" type="button" name="submitOrderForm" role="tab"
                    aria-controls="tab_item-3"></button>
        </div>
    </div>
</div>