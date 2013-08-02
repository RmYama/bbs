<?php
/* @var $this CommentController */
/* @var $model Comment */

$this->breadcrumbs=array(
	'Comments'=>array('board/index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Comment', 'url'=>array('index')),
	array('label'=>'Create Comment', 'url'=>array('create')),
	array('label'=>'Update Comment', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Comment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'この投稿を削除しますか？')),
	array('label'=>'Manage Comment', 'url'=>array('admin')),
);
?>

<h1>View Comment #<?php echo $model->id; ?></h1>
<?php if($model->res_id > 0): ?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'label'=>'ニックネーム',
			'type' =>'raw',
			'value'=>CHtml::encode(Yii::app()->user->getState('nickname')),
		),
		'contents',
		'created_at',
	),
)); ?>
<?php else: ?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'label'=>'タイトル',
			'type' =>'raw',
			'value'=>$model->getTitle($model->board_id),
		),
		array(
			'label'=>'ニックネーム',
			'type' =>'raw',
			'value'=>CHtml::encode(Yii::app()->user->getState('nickname')),
		),
		'contents',
		'created_at',
	),
)); ?>
<?php endif; ?>
