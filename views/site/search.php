<?php

/* @var $this yii\web\View */
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="row">
    <div class="col-md-12">
        <h1>For search term "<?php echo($repos['query']); ?>" found</h1>
    </div>
</div>
<?php
$paginationLinks = LinkPager::widget([
    'pagination'     => $pages,
    'firstPageLabel' => '<<',
    'lastPageLabel'  => '>>',
    'prevPageLabel'  => '<',
    'nextPageLabel'  => '>',
    'maxButtonCount' => '3',
]);

echo $paginationLinks;
?>

<?php foreach ($repos['repos'] as $repo): ?>
    <div class="row highlight">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-5">
                    <?php /** @var app\models\Repo $repo */ ?>
                    View repo detail:
                    <a href=<?php echo '"' . Url::to(['site/repo', 'id' => $repo->getFullName()]) . '">' . $repo->getName(); ?></a>
                </div>
                <div class="col-md-3">
                    <a href=<?php echo '"' . $repo->getOwner()->getBlog() . '">' . $repo->getOwner()->getBlog(); ?></a>
                </div>
                <div class="col-md-4">
                    View user detail:
                    <a href=<?php echo '"' . Url::to(['site/user', 'id' => $repo->getOwner()->getLogin()]) . '">' . $repo->getOwner()->getLogin(); ?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php echo "Description: " . $repo->getDescription(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?php echo "Watchers: " . $repo->getWatchersCount(); ?>
                </div>
                <div class="col-md-4">
                    <?php echo "Forks: " . $repo->getForksCount(); ?>
                </div>
                <div class="col-md-4">
                    <button
                        id="<?php echo $repo->getRepoId(); ?>"
                        class="btn btn-default btn-sm btn-status pull-right"
                        type="button"><?php echo $repo->getStatusText(); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php
echo $paginationLinks;
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('.btn-status').on('click', function () {
            var repo_id = $(this).attr('id');
            $.ajax({
                type: 'POST',
                cache: false,
                data: {repo_id: repo_id},
                url: <?php echo '"' . Url::to(['site/change-repo-status']) . '"' ?>,
                success: function (response) {
                    $('#' + repo_id).text(response.label);
                },
                error: function () {
                    console.log('failure');
                }
            });
        });
    });
</script>