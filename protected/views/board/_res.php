<?php foreach($comments as $comment): ?>

<div class="comment" id="c<?php echo $comment->res_id; ?>">
<?php if($comment->res_id>0): ?>
	<?php echo CHtml::link("{$comment->res_id}", $comment->getUrl($board), array(
		'class'=>'cid',
		'title'=>'Permalink to this comment',
	)); ?>
<?php endif; ?>
	<div class="nickname">
		<?php echo CHtml::encode($comment->getNickname($comment->user_id)); ?>
	</div>

	<div class="content">
		<?php echo nl2br(CHtml::encode($comment->contents)); ?>
	</div>

</div><!-- comment -->
<?php endforeach; ?>