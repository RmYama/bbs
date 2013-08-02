<?php
/* @var $this BoardController */
/* @var $data Board */
?>

<div class="view">
	<h2><?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->id)); ?></h2>
	<div class="contents">
		<p><?php echo nl2br(CHtml::encode($data->getThreadContents($data->id))); ?></p>
	</div>
	<div class="item">
	<dl>
		<dt>レス数</dt>
		<dd><?php echo CHtml::encode($data->resCount); ?></dd>
	</dl>
	<p><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:
	   <?php echo CHtml::encode($data->created_at); ?></p>
	</div>
</div>