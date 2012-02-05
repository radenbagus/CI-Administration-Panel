<ul>
	<?php if($submenu): ?>
		<?php foreach ($submenu as $sm): ?>
			<li class="<?php if($sm->weight == 0) { echo "first"; } elseif($sm->weight == 0) { echo "leaf last"; } else { echo "leaf"; }?> <?php if($sm->id == $current) echo "selected"; ?>"><a href="/work/gallery/<?=$gallery ?>/<?=$sm->id ?>"><?=$sm->name ?></a></li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>