<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="row">
    <?php if ($repo['status_ok']): ?>
        <div class="col-md-offset-1 col-md-2">
            <div class="col-md-12">
                <img src="<?php echo $repo['avatar_url'] ?>" class="img-rounded" alt="Cinque Terre" width="150">
            </div>
            <div class="col-md-offset-3 col-md-2">
                <button class="btn btn-default" type="button">Like</button>
            </div>
        </div>
        <div class="col-md-7">
            <h1><?php echo $repo['name'] ?></h1>
            <br>
            <h4><?php echo 'Company: ' . $repo['company'] ?></h4>
            <h4><?php echo 'Blog: ' . $repo['blog'] ?></h4>
            <h4><?php echo 'Followers: <a href="' . $repo['followers'] . '/>' ?></h4>
        </div>
        <div class="col-md-1"></div>
    <?php else: ?>
        <div class="alert alert-danger">
            <strong>Error!</strong> <?php echo $repo['message'] ?>
        </div>
    <?php endif; ?>
</div>
