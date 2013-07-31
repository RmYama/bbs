<?php
/* @var $this BoardController */
/* @var $model Board */

$this->breadcrumbs=array(
	'Boards'=>array('index'),
	$model->title,
);
$this->pageTitle=$model->title;
?>
<h1><?php echo $model->title; ?></h1>
<div id="list">
<?php $this->renderPartial('_res',array(
	'board'=>$model,
	'comments' =>$model->comments,
)); ?>
<br />
<h3>この投稿にレスする</h3>
<?php if(!Yii::app()->user->isGuest): ?>
	<?php if(Yii::app()->user->hasFlash('commentSubmitted')): ?>
		<div class="flash-success">
			<?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
		</div>
	<?php else: ?>
		<?php $this->renderPartial('/comment/_form',array(
			'model'=>$comment,
		)); ?>
	<?php endif; ?>
<?php else: ?>
<p>レスを投稿するにはログインが必要です。</p>
<a href="http://localhost/bbs/index.php?r=site/login">ログインする</a>
<?php endif; ?>
</div>


