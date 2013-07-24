<?php
/* @var $this BoardController */
/* @var $model Board */
/* @var $form CActiveForm */
?>

<div class="form">
<?php echo CHtml::form('', 'post', array('enctype' => 'multipart/form-data')); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo CHtml::errorSummary($model); ?>

	<div class="row">
		<?php echo CHtml::activeLabel($model,'title'); ?>
		<?php echo CHtml::activeTextField($model,'title',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo CHtml::error($model,'title'); ?>
	</div>

	<div class="row" style="margin-bottom:15px;">
		<?php echo CHtml::activeLabel($model,'nickname'); ?>
		<?php echo CHtml::encode(Yii::app()->user->getState('nickname')); ?>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabel($model,'contents'); ?>
		<?php echo CHtml::activeTextArea($model,'contents',array('rows'=>10,'cols'=>50)) ?>
		<?php echo CHtml::error($model,'contents'); ?>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabel($model, 'image'); ?>
		<?php echo CHtml::activeFileField($model, 'image'); ?>
	</div><!-- /.row -->
	<?php if (!$model->isNewRecord): ?>
	<div class="row">
		<?php echo CHtml::image(Yii::app()->baseUrl.'/images/'.$model->image, 'image', array('width' => 200)); ?><br />
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php 
		 //echo CHtml::submitButton($model->isNewRecord ? '投 稿' : '更 新'); 
		 echo CHtml::submitButton('確 認',array('name' => 'confirm'));
		?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->