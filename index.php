<!DOCTYPE html>
<html lang="en">

<?php
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        include 'model.php';

        if (!model::doesUserExist($id)){
            header("Location: ../default.html");
        }
    } else {
        header("Location: ../default.html");

    }
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">

    <title>Dimensional ANnotation Tool for Emotions</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <link href="css/bootstrap-slider.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Help Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">DANTE - Help</h4>
          </div>
          <div class="modal-body">
            <p><b>Please carefully read the following instructions to properly use the annotation tool.</b></p>
            <p>On the <b>left</b> side of the screen you find a list of videos. These videos need to be annotated when the icon is
            <i class="glyphicon glyphicon-unchecked"></i>, and are already annotated when the icon is <i class="glyphicon glyphicon-ok"></i>.</p>
            <p>On the <b>right</b> side of the screen, when a video is selected, you find a video player with an annotation bar and a <abbr title="Self Assessment Manikin" class="initialism">SAM</abbr> guideline. Recording of annotations begins by <b>clicking</b> on the video. Moving on the annotation bar changes the recorded annotation value for the selected emotional dimension (valence/arousal).<p>
            <p><b>Please note</b>
            <ul>
                <li>The annotations are saved <b>only</b> when the video has reached the end.</li>
                <li>When you annotate a video already annotated, old records will be <b>overwritten</b>.</li>
            </ul>
            <br> 
            <p>For questions, information and details please refer to the Credits section.</p>
          </div>
          <div class="modal-footer">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="dismiss"> Don't show again
                </label>
            </div>
            <button type="button" class="btn btn-default" data-dismiss="modal">I understand</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Credits Modal -->
    <div class="modal fade" id="creditsModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">DANTE - Credits</h4>
          </div>
          <div class="modal-body">
            <p>
                DANTE (Dimensional ANnotation Tool for Emotions) is a project developed by the <abbr title="Perceptual computing and Human Sensing" class="initialism">PHuSe</abbr> Lab from Università degli Studi di Milano, Italy, in collaboration with the Département Informatique - Ecole Polytechnique de l'Université François Rabelais de Tours, France. The tool is part of a multimodal dataset acquired with the aim to study emotional response in presence of amusement stimulus. For more information or to use the tool in other works, please cite:
                <blockquote class="blockquote-reverse">
		Boccignone, G., Conte, D., Cuculo, V., and Lanzarotti, R. (2017) <b>AMHUSE: A Multimodal dataset for HUmour SEnsing</b>.<br>In <i>Proceedings of 19th ACM International Conference on Multimodal Interaction.</i> (ICMI’17), ACM.<br><small>DOI: <a target="_blank" href="http://doi.org/10.1145/3136755.3136806">10.1145/3136755.3136806</a></small>
                </blockquote>
            </p>
            <p>
            <address>
              <strong>PHuSe Lab.</strong><br>
              Via Comelico 39, room T318<br>
              Milano, 20135 Italy<br>
              <abbr title="Phone">P:</abbr> +39 02 503 16285<br>
              <a href="mailto:#">phuselab[at]di.unimi.it</a><br>
	      <a href="http://www.phuselab.di.unimi.it" target="_blank">www.phuselab.di.unimi.it</a>
            </address>
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div id="wrapper" class="toggled">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div>
                <ul class="sidebar-nav">
                    <li class="sidebar-brand">
                        <a href="#">
                            <img src="img/banner.png"/>
                        </a>
                    </li>
                    <?php include 'videoMenuList.php';?>
                </ul>
            </div>

            <footer class="footer">
                <div class="text-center">
                    <a type="button" class="btn" data-toggle="modal" data-target="#creditsModal"><b>Credits</b></a>
                    <a type="button" class="btn" href="panelControl.php"><b>Admin</b></a>
                </div>
            </footer>
        </div>
          
        <!-- /#sidebar-wrapper -->


        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-2">
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">
                            <span id="menu-toggle-span" class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Videos
                        </a>
                    </div>

                    <div class="col-lg-10 videoFrame" style="display: <?php if(isset($_GET['vid'])) echo 'block'; else echo 'none' ?>">

                        <div id="saving" class="alert alert-info" style="display: none">
                            <strong>Saving</strong> Please wait...
                        </div>

                        <div id="success-alert" class="alert alert-success alert-dismissible" role="alert" style="display: none">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden=true>&times;</span>
                            </button>
                            <strong>Done</strong> Annotations saved correctly.
                        </div>

                        <div id="error-alert" class="alert alert-danger alert-dismissible" role="alert" style="display: none">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden=true>&times;</span>
                            </button>                        
                            <strong>Error</strong> An error has occured while saving the annotations. Please contact the mantainer.
                        </div>
        
                        <!--Sezione che carica il titolo del video e il video stesso-->
                        <?php include './videoPlayer.php'; ?>

                        <!--Includo la slidebar e il suo funzioanmento, registrando automaticamente i valori dentro valSlidebar-->
                        <?php include './slidebar.php'; ?>
                    </div>


                </div>             
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script type="text/javascript" src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

    <script type="text/javascript" src="js/bootstrap-slider.min.js"></script>

    <script type="text/javascript" src="js/js.cookie.js"></script>

    <!-- Menu Toggle Script -->
    <script>

    var timer = null;

    // show help modal when needed
    $(document).ready(function() {
        if (Cookies.get('modal_shown') == null) {
            $('#helpModal').modal('show');
        }
        $('#slider').slider('relayout');

        $('#helpModal').on('hidden.bs.modal', function (e) {
            if ($("input[name=dismiss]", this).is(":checked")) {
                Cookies.set('modal_shown', 'yes', { expires: 7, path: '/' });
            }
        });
    });

    // handle sidebar
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        $(".footer").toggleClass("hidden");
        $("#menu-toggle-span").toggleClass("glyphicon-menu-left").toggleClass("glyphicon-menu-right");
    });

    // show slider value
    $('#slider').slider({
        formatter: function(value) {
            return 'Current: ' + value;
        }
    });

    $('#annoSlider').click(function(e) {
        $('#annoSlider').toggleClass('with-focus');
    });


    $(document).mousemove(function(e) {
        if ($("#annoSlider").hasClass("with-focus")) {
          val = ((e.clientX - $("#annoSlider").offset().left) / $("#annoSlider").width()) * 2 - 1;
          if (val > 1) {
            val = 1;
          }
          if (val < -1) {
            val = -1;
          }
          $("#slider").slider('setValue', val, true)
          //("#annoSlider").slider('refresh');          
        }
    });

    // start play when video is clicked
    $('#annoVideo').click(function() {
        if (this.paused) {
            this.play();

            var anno_time = (1 / <?php echo $GLOBALS['anno_rate'] ?>) * 1000;
            timer = setInterval(readVid, anno_time);
        }
    });

    // update slider UI when show/hide sidebar    
    $("#wrapper").bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(e){
        $('#slider').slider('relayout');        
    });

    var arrayAnnot = 
        {
            userId:<?php echo $_GET['id'] ?>,
            video:<?php echo '"'.$_GET['vid'].'"' ?>,
            type:<?php echo '"'.$_GET['type'].'"' ?>,
            valvid:[]
        };

    function readVid() {
        currentTime  = document.getElementById("annoVideo").currentTime;
        currentValue = $('#slider').slider('getValue');

        arrayAnnot.valvid.push({timeStamp:currentTime, value: currentValue});

        console.log(currentTime + ' - ' + currentValue);
    }

    var video = $('#annoVideo');

    //update HTML5 video current play time
    video.on('timeupdate', function() {
	var currentPos = video[0].currentTime;
    	var maxduration = video[0].duration; //Get video duration
   	var percentage = 100 * currentPos / maxduration; //in %
    	$('.timeBar').css('width', percentage+'%');
    });

    video.on('ended', function() {
	var json = JSON.stringify(arrayAnnot);
	//console.log(json);

	clearInterval(timer);
	
	$('#saving').fadeIn();

	$.ajax({
	    type: "POST",
	    url: "saveAnnotation.php",
	    data: {data : json}, 
	    cache: false,
	    success: function (response) {
	        $('#saving').fadeOut(function() {$('#success-alert').fadeIn()});
	        /*setTimeout(function() {
	            window.location.reload();
	        }, 1000);                */
	    },
	    error: function (xhr, ajaxOptions, thrownError) {
	        $('#saving').fadeOut(function() {$('#error-alert').fadeIn()});
	        console.log(xhr.responseText);
	    }
	});
    });

    </script>

</body>

</html>
