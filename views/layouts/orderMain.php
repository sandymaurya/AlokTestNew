<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

//use app\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});;
/* To initialize BS3 popovers set this below */
$(function () { 
    $("[data-toggle='popover']").popover(); 
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>    
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <?php echo $this->render("orderheader") ?>
<?= $content ?>
<?php echo $this->render("orderFooter") ?>
        <script type="application/x-javascript" src="/mm-js/jquery.easydropdown.js" />
        <script type="application/x-javascript" src="/mm-js/easing.js" />
        <script type="application/x-javascript" src="/mm-js/easyResponsiveTabs.js" />
        <script type="application/x-javascript" src="/mm-js/responsiveslides.min.js" />
        <script type="application/x-javascript" src="/mm-js/required.part.js" />
        <script type="application/x-javascript" src="/mm-js/order.form.js" />
<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
