<?php
/* @var $this CommentController */
/* @var $data Comment */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('board_id')); ?>:</b>
	<?php echo CHtml::encode($data->board_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('res_id')); ?>:</b>
	<?php echo CHtml::encode($data->res_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
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

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('del_flg')); ?>:</b>
	<?php echo CHtml::encode($data->del_flg); ?>
	<br />

	*/ ?>

</div>