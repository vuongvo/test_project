<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\Post */

$this->title = 'Create Post';
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
	 /*$(document).ready(function(){
	 	$("#button").click(function(){
	 		 var name = $("#name").val() ? $("#name").val() : "" ;
	 		 (name) ? $("#confirm_name").val(name) : '';
	 	})
	 })*/
</script>
<div class="post-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'id' => 'name']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image')->fileInput() ?>
    
    <!--
     // $form->field($model, 'name')->dropDownList($postList, ['prompt'=>'Choose Option','id' => 'post_id','class' => 'form-control','style' => ['width' => '100%']]); 
	-->
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id' => 'button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
 