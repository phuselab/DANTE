<!--Firefox fires the timeupdate event once per frame. Safari 5 and Chrome 6 fire every 250ms. Opera 10.50 fires every 200ms.-->
<?php
    $id = "";
    $vid = "";
    $type = "";
    $nameGroup = "";
    
    if (isset($_GET['id'])) {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS); 
        if (model::doesUserExist($id)){
            $nameGroup = model::getGroupFromId($id);
        }
    }
    if (isset($_GET['vid'])) {
        $vid = filter_input(INPUT_GET, 'vid', FILTER_SANITIZE_SPECIAL_CHARS); 
    }
    if (isset($_GET['type'])) {
        $type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_SPECIAL_CHARS); 
    }
    $vidpath = $nameGroup."/".$vid;
?>
<h4 id="typeVid"><?php echo $vid;?> <small class="text-capitalize"><?php echo $type;?></small></h4>
<div class="progressBar">
    <div class="timeBar"></div>
</div>
<div class="btn embed-responsive embed-responsive-16by9">

	<video id="annoVideo">
	    <source src="video/<?php echo $vidpath?>" type="video/mp4">
	</video>

</div>

