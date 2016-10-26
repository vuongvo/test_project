<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form ActiveForm */
?>
<?php $baseUrl = Url::base(true); ?>
<div class="site-post-index">
    <?php
   // $this->title = 'Update Post: ' . $post['name'];
    $this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
    $this->params['breadcrumbs'][] = "Update";
    //$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $post['id']]];
    ?>
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'name')->textInput(['value' => $post['name']]) ?>
        <?= $form->field($model, 'description')->textArea(['value' => $post['description'],'rows' => 5]) ?>
        <?php $image = $post['image'] ? $post['image'] : "no_avatar.png" ;?>
        <img src="<?php echo $baseUrl.'/uploads/'.$image?>" style="width:30px;height:30px">
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-post-index -->
