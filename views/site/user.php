<?php
use yii\helpers\Url;

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
            <div class="clearfix"></div>
            <br>
            <div class="col-md-offset-7 col-md-2">
                <button id="<?php echo $user->getLogin(); ?>"
                        class="btn btn-default btn-sm btn-status pull-right"
                        type="button"><?php echo $user->getStatusText(); ?></button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.btn-status').on('click', function () {
                var login = $(this).attr('id');
                $.ajax({
                    type: 'POST',
                    cache: false,
                    data: {login: login},
                    url: <?php echo '"' . Url::to(['site/change-user-status']) . '"' ?>,
                    success: function (response) {
                        $('#' + login).text(response.label);
                    },
                    error: function () {
                        console.log('failure');
                    }
                });
            });
        });
    </script>
</div>
