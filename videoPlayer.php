<!--Firefox fires the timeupdate event once per frame. Safari 5 and Chrome 6 fire every 250ms. Opera 10.50 fires every 200ms.-->
<?php $nameGroup = model::getGroupFromId($_GET['id']); ?>
<h4 id="typeVid"><?php echo $_GET['vid'];?> <small class="text-capitalize"><?php echo $_GET['type'];?></small></h4>
<div class="progressBar">
    <div class="timeBar"></div>
</div>
<div class="btn embed-responsive embed-responsive-16by9">

	<video id="annoVideo">
	    <source src="video/<?php echo $nameGroup."/".$_GET['vid'];?>" type="video/mp4">
	</video>

</div>

