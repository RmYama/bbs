<?php
/* @var $this BoardController */
/* @var $dataProvider CActiveDataProvider */


$this->menu=array(
	array('label'=>'Create Board', 'url'=>array('create')),
	array('label'=>'Manage Board', 'url'=>array('admin')),
);
?>

<h1>スレッド一覧</h1>
<a href="/bbs/index.php?r=board/create">スレッド新規作成</a>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
