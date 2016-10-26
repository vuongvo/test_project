<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$baseUrl = Url::base(true);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".confirm").click(function(){
            var id;
            id = $(this).data("id");
            $("#delete").click(function(){
                $.ajax({
                    type : "POST",
                    url : "http://localhost/demo_yii2/backend/web/index.php/?r=post/delete_ajax",
                    data : {"id" : id},
                    success : function (data) {
                        window.location.reload();
                    }
                })
            })
        })
    })
</script>
<?php
$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <?php if(!empty(Yii::$app->session->getFlash('message'))) { ?>   
    <div class ="alert alert-success">
        <?= Yii::$app->session->getFlash('message'); ?>
    </div>
    <?php } ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <a href="<?php echo $baseUrl.'?r=post/create'?>" class="btn btn-success">Create Post</a>
    <table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php  if ($Posts) { ?>
    <?php  foreach ($Posts as $Post) : ?>
        <tr>
            <td><?php echo $Post->id ;?></td>
            <td><?php echo $Post->name ;?></td>
            <td><?php echo $Post->description; ?></td>
            <td>
                <a href="<?php echo $baseUrl.'?r=post/update&id='.$Post->id?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                <a href="#" class="confirm" data-id="<?php echo $Post->id ?>"><i class="fa fa-times" aria-hidden="true" data-toggle="modal" data-target="#myModal"></i></a>
            </td>
      </tr>
      <?php endforeach; ?>
     <?php } ?>
    </tbody>
  </table>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Do You Want Delete ?</h4>
      </div>
      <div class="modal-footer">
       <button type="button" id ="delete" class="btn btn-danger" data-dismiss="modal">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php 
    echo LinkPager::widget([
    'pagination' => $pagination,
    ]);
?>