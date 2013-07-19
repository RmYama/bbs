<?php
/* @var $this BoardController */
/* @var $model Board */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'board-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row" style="margin-bottom:15px;">
		<?php echo $form->labelEx($model,'nickname'); ?>
		<?php echo CHtml::encode(Yii::app()->user->getState('nickname')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contents'); ?>
		<?php echo CHtml::activeTextArea($model,'contents',array('rows'=>10,'cols'=>50)) ?>
		<?php echo $form->error($model,'contents'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'images'); ?>
		<?php echo CHtml::activeFileField($model,'images') ?>
		<?php echo $form->error($model,'images'); ?>
	</div>
<!--
	<div class="row">
		<?php // echo $form->labelEx($model,'created_at'); ?>
		<?php // echo $form->textField($model,'created_at'); ?>
		<?php // echo $form->error($model,'created_at'); ?>
	</div>
-->
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '投 稿' : '更 新'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->