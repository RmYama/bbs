<?php
/* @var $this BoardController */
/* @var $model Board */

$this->breadcrumbs=array(
	'Boards'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Board', 'url'=>array('index')),
	array('label'=>'Manage Board', 'url'=>array('admin')),
);
?>

<h1>Create Board</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>