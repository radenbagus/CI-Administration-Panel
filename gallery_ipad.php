<style type="text/css" media="screen">
  .slides_container {
    width:1024px;
    height:400px;
  }
  .slides_container div {
    width:1024px;
    height:400px;
    display:block;
    text-align: center;
  }
</style>

<div id="slides" style="text-align: center;">
		<div class="slides_container">
			<?php if($photos): ?>
				<?php foreach ($photos as $p): ?>
					<div>
						<img style="text-align:center" <?php if($p->vh == 'h'){ echo 'width="1024"'; } else { echo 'height="500"';} ?> src="/img/gallery/<?=$p->name ?>" alt="Slide <?=$p->name ?>">
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div style="height: 210px; overflow: auto; padding-top: 60px;">
					<h1>No pictures in this section</h1>
				</div>
			<?php endif; ?>	
		</div>

		<?php if($photos): ?>
			<a href="#" class="prev"><span class="arrow previous"></span></a>
			<a href="#" class="next"><span class="arrow next"></a>
		<?php endif; ?>
</div>
<div id="gallery_nav" class="bbottom bleft bright" style="height: 30px; width: 1024px">
	<ul id="gallery_nav">
		<?php if($submenu): ?>
			<?php foreach ($submenu as $sm): ?>
				<li class="<?php if($sm->weight == 0) { echo "first"; } elseif($sm->weight == 0) { echo "leaf last"; } else { echo "leaf"; }?> <?php if($sm->id == $current) echo "selected"; ?>"><a href="/work/gallery/<?=$gallery ?>/<?=$sm->id ?>"><?=$sm->name ?></a></li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
</div>

<script type="text/JavaScript">
</script>