<?php
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
/** @var app\models\Repo $repo */
$repo = $response['data'];
?>
<div class="row">
    <?php if ($response['status_ok'] && $repo): ?>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php echo $repo->getFullName(); ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4><?php echo 'Description: ' . $repo->getDescription(); ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4><?php echo 'Watchers: ' . $repo->getWatchersCount(); ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4><?php echo 'Forks: ' . $repo->getForksCount(); ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4><?php echo 'Open issues: ' . $repo->getOpenIssuesCount(); ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>Homepage: <a href=<?php echo '"' . $repo->getHomepage() . '">' . $repo->getHomepage(); ?></a></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>GitHub repo: <a href=<?php echo '"' . $repo->getHtmlUrl() . '">' . $repo->getHtmlUrl(); ?></a></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4><?php echo 'Created at: ' . $repo->getCreatedAt(); ?></h4>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            <strong>Error!</strong> <?php echo $response['message'] ?>
        </div>
    <?php endif; ?>
    <div class="col-md-6">
        <?php if ($contributors && $contributors['status_ok']): ?>
        <h1>Contributors:</h1>
        <?php foreach ($contributors['contributors'] as $contributor): ?>
            <?php if ($contributor): ?>
                <div class="row highlight">
                    <div class="col-xs-8"><a
                        href="<?php echo Url::to(['site/user', 'id' => $contributor->getLogin()]); ?>"><?php echo $contributor->getLogin(); ?></a>
                    </div>
                    <div class="col-xs-4">
                        <button id="<?php echo $contributor->getLogin(); ?>"
                                class="btn btn-default btn-sm btn-status pull-right"
                                type="button"><?php echo $contributor->getStatusText(); ?></button>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <div class="alert alert-danger">
            <strong>Error!</strong> <?php echo $contributors['message'] ?>
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
