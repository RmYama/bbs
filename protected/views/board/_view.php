<?php
/* @var $this BoardController */
/* @var $data Board */
?>

<div class="view">

	<b><?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->id)); ?></b>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />
	<b><?php echo CHtml::encode($data->resCount); ?></b>
	<br />
</div>