<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
/** @var app\models\Owner $user */
$user = $response['data'];
?>
<div class="row">
    <?php if ($response['status_ok'] && $user): ?>
        <div class="col-md-offset-1 col-md-2">
            <div class="col-md-12">
                <img src="<?php echo $user->getAvataUrl(); ?>" class="img-rounded" alt="Cinque Terre" width="150">
            </div>
            &nbsp;
            <div class="col-md-offset-3 col-md-2">
                <button class="btn btn-default" type="button"><?php echo $user->getStatusText(); ?></button>
            </div>
        </div>
        <div class="col-md-7">
            <h1><?php echo $user->getName(); ?></h1>
            <br>
            <h4><?php echo 'Company: ' . $user->getCompany(); ?></h4>
            <h4><?php echo 'Blog: ' . $user->getBlog(); ?></h4>
            <h4><?php echo 'Followers: <a href="' . $user->getFollowers(). '/>' ?></h4>
        </div>
        <div class="col-md-1"></div>
    <?php else: ?>
        <div class="alert alert-danger">
            <strong>Error!</strong> <?php echo $response['message'] ?>
        </div>
    <?php endif; ?>
</div>
