<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

//use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="menu-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>
                        <a href="<?php echo Yii::$app->homeUrl; ?>"> Homepage</a>
                        <?php echo $form = Html::beginForm(['site/search'], 'get', ['class' => 'form-inline pull-right']); ?>
                        <div class="form-group">
                            <?= Html::textInput('search', '', ['class' => 'form-control']); ?>
                        </div>
                        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                        <?php Html::endForm() ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Test MobiDev <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
