<?php
/* @var $this BoardController */
/* @var $model Board */

$this->breadcrumbs=array(
	'Boards'=>array('index'),
	'Confirm',
);
?>

<h1><?php echo $this->action->id . ' - 確認画面'; ?></h1>
<?php echo Chtml::statefulForm() ; ?>
	<div class="row">
		<?php echo Chtml::activeLabel($model,'title'); ?><br />
		<?php echo Chtml::encode($model->title); ?>
	</div>
	<div class="row">
		<?php echo CHtml::encode(Yii::app()->user->getState('nickname')); ?><br />
		<?php echo Chtml::encode($model->nickname); ?>
	</div>
	<div class="row">
		<?php echo Chtml::activeLabel($model,'contents'); ?><br />
		<?php echo Chtml::encode($model->contents); ?>
	</div>
	<div class="row">
		<?php echo Chtml::activeLabel($model,'image'); ?><br />
		<?php echo Chtml::image($model->image, 'image', array('width' => $model->fileWidth)); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('戻 る', array('name' => 'back')); ?>
		<?php echo CHtml::submitButton('投 稿', array('name' => 'finish')); ?>
	</div>
</from>