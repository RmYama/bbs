<?php
/* @var $this CommentController */
/* @var $model Comment */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'board_id'); ?>
		<?php echo $form->textField($model,'board_id'); ?>
		<?php echo $form->error($model,'board_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'res_id'); ?>
		<?php echo $form->textField($model,'res_id'); ?>
		<?php echo $form->error($model,'res_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contents'); ?>
		<?php echo $form->textArea($model,'contents',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'contents'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image_file_t'); ?>
		<?php echo $form->textField($model,'image_file_t',array('size'=>60,'maxlength'=>1024)); ?>
		<?php echo $form->error($model,'image_file_t'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image_file_o'); ?>
		<?php echo $form->textField($model,'image_file_o',array('size'=>60,'maxlength'=>1024)); ?>
		<?php echo $form->error($model,'image_file_o'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'del_flg'); ?>
		<?php echo $form->textField($model,'del_flg'); ?>
		<?php echo $form->error($model,'del_flg'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->