<?php foreach($comments as $comment): ?>

<div class="comment" id="c<?php echo $comment->res_id; ?>">
<?php if($comment->res_id>0): ?>
	No.<?php echo CHtml::encode($comment->res_id); ?> 
	<b class="nickname">
		<?php echo CHtml::encode($comment->getNickname($comment->user_id)); ?>
	</b>
	<div class="content">
		<?php echo nl2br(CHtml::encode($comment->contents)); ?>
	</div>
<?php else: ?>
	<div class="content">
		<?php echo nl2br(CHtml::encode($comment->contents)); ?>
	</div>
	<div class="nickname" align="right">
		<b>By <?php echo CHtml::encode($comment->getNickname($comment->user_id)); ?></b>
	</div>
<?php endif; ?>
	<div class="time" align="right">
		<?php echo CHtml::activeLabel($comment,'created_at');?>
		<?php echo CHtml::encode($comment->created_at); ?> 
	</div>
<?php if(!Yii::app()->user->isGuest): ?>
<?php if(Yii::app()->user->id == $comment->user_id): ?>
	<div class="edit" align="right">
		<?php echo CHtml::link('編集',$comment->getUrl(0));?>
		<?php echo CHtml::link('削除',$comment->getUrl(1));?>
	</div>
<?php endif; ?>
<?php endif; ?>

</div><!-- comment -->
<?php endforeach; ?>

