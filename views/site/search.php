<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="row">
    <div class="col-md-12">
        <h1>For search term "<?php echo($repos['query']); ?>" found</h1>
    </div>
</div>
<?php foreach ($repos['repos'] as $repo): ?>
    <div class="row highlight">

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <a href=<?php echo '"' . $repo['html_url'] . '">' . $repo['name'] ?></a>
                </div>
                <div class="col-md-offset-1 col-md-5">
                    <a href=<?php echo '"' . $repo['owner']['blog'] . '">' . $repo['owner']['blog'] ?></a>
                </div>
                <div class="col-md-offset-1 col-md-2">
                    <!--                    --><?php //var_dump($repo['owner']) ?>
                    <a href=<?php echo '"' . $repo['owner']['html_url'] . '">' . $repo['owner']['login'] ?></a>
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
                    <!--                    <a href=-->
                    <?php //echo '"' . $repo['html_url'] . '">' . $repo['name'] ?><!--</a>-->
                    <button
                        id="<?php echo $repo['name']; ?>"
                        class="btn btn-default btn-sm btn-status pull-right"
                        type="button">Like</button>
                </div>
            </div>
        </div>
        <!--        <div class="col-md-2">-->
        <!--            <div class="row">-->
        <!--                -->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->

        <!--    <div class="col-md-offset-2  col-md-8 highlight">-->
        <!--                    <h4>--><?php //echo 'Created at: ' . $repo['full_name'] ?><!--</h4>-->
        <!--    </div>-->
        <!--        </div>-->
    </div>
<?php endforeach; ?>
