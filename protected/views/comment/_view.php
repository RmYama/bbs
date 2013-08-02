<?php
/* @var $this CommentController */
/* @var $data Comment */
?>

<div class="view">
<?php if($data->res_id==0):?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />
<?php endif;?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nickname')); ?>:</b>
	<?php echo CHtml::encode(Yii::app()->user->getState('nickname')); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contents')); ?>:</b>
	<?php echo Yii::app()->format->formatNtext($data->contents); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('image_file_t')); ?>:</b>
	<?php echo CHtml::encode($data->image_file_t); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image_file_o')); ?>:</b>
	<?php echo CHtml::encode($data->image_file_o); ?>
	<br />
	*/ ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />
</div>