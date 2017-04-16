<?php
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="row">
    <?php if ($repos['status_ok']): ?>
        <div class="col-md-offset-1 col-md-5">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php echo $repos['full_name'] ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4><?php echo 'Description: ' . $repos['description'] ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4><?php echo 'Watchers: ' . $repos['watchers_count'] ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4><?php echo 'Forks: ' . $repos['forks_count'] ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4><?php echo 'Open issues: ' . $repos['open_issues_count'] ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>Homepage: <a href=<?php echo '"' . $repos['homepage'] . '">' . $repos['homepage'] ?></a></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>GitHub repo: <a href=<?php echo '"' . $repos['html_url'] . '">' . $repos['html_url'] ?></a></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4><?php echo 'Created at: ' . $repos['created_at'] ?></h4>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            <strong>Error!</strong> <?php echo $repos['message'] ?>
        </div>
    <?php endif; ?>
<!--            --><?php //var_dump($contributors); die;?>
    <div class="col-md-5">
        <?php if ($contributors && $contributors['status_ok']): ?>
        <h1>Contributors:</h1>
        <?php foreach ($contributors['contributors'] as $contributor): ?>
            <?php if ($contributor): ?>
                <div class="row highlight">
                    <div class="col-xs-8"><a
                            href="<?php echo $contributor->getHtmlUrl(); ?>"><?php echo $contributor->getLogin(); ?></a>
                    </div>
                    <div class="col-xs-4">
                        <button id="<?php echo $contributor->getLogin();?>" class="btn btn-default btn-sm btn-status pull-right" type="button"><?php echo $contributor->getStatusText(); ?></button>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="col-md-1"></div>
<?php else: ?>
    <div class="alert alert-danger">
        <strong>Error!</strong> <?php echo $contributors['message'] ?>
    </div>
<?php endif; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.btn-status').on('click', function() {
                var login = $(this).attr('id');
                $.ajax({
                    type     :'POST',
                    cache    : false,
                    data: {login: login},
                    url  : <?php echo '"'.Url::to(['site/change-user-status']).'"' ?>,

                success  : function(response) {
                    $('#'+login).text(response.label);
                    console.log(response.label,this);
                },
                error: function(){
                    console.log('failure');
                }
            });
            });
        });
    </script>
</div>
