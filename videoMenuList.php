<?php
    $video = Model::getVideoByUsrId($id);

    while($row = mysqli_fetch_array($video)){
        echo 
          '<li>'
            . '<a href="index.php?id='.$id.'&vid='.$row['name'].'&type=arousal">'
            . (Model::doesAnnotationExist($id,$row['name'],'arousal') ?  
              '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ' :
              '<span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span> ')
            . $row['name'] . ' - Arousal </a>'
        . '</li>'
        . '<li>'
            . '<a href="index.php?id='.$id.'&vid='.$row['name'].'&type=valence">'
            . (Model::doesAnnotationExist($id,$row['name'],'valence') ?  
              '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ' :
              '<span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span> ')
            . $row['name'] . ' - Valence </a>'
        . '</li>'

        ;
    }
?>
