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
    $paginationLinks =  LinkPager::widget([
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
                    View repo detail: <a href=<?php echo '"' . Url::to(['site/repo', 'id' => $repo['full_name']]) . '">' . $repo['name'] ?></a>
                </div>
                <div class="col-md-3">
                    <a href=<?php echo '"' . $repo['owner']['blog'] . '">' . $repo['owner']['blog'] ?></a>
                </div>
                <div class="col-md-4">
                    View user detail: <a href=<?php echo '"' . Url::to(['site/user', 'id' => $repo['owner']['login']]) . '">' . $repo['owner']['login'] ?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php echo "Description: " . $repo['description'] ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?php echo "Watchers: " . $repo['watchers_count'] ?>
                </div>
                <div class="col-md-4">
                    <?php echo "Forks: " . $repo['forks_count'] ?>
                </div>
                <div class="col-md-4">
                    <button
                        id="<?php echo $repo['name']; ?>"
                        class="btn btn-default btn-sm btn-status pull-right"
                        type="button">Like</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php
    echo $paginationLinks;
?>
