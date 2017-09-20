<?php
//Svuoto tabella videos, groups e relgroupvideo dal database
//Per ogni cartella sul server, carica il nome dei video nella tabella "Videos"
//Carica nella tabella "gropus" il nome del gruppo (nome cartella) a cui quei video appartengono
//Collega in RelGropuVideo il gruppo ai video
session_start();
if($_SESSION['loggedin']){
    include 'model.php';

    model::clearTables();

    //array con i nomi delle cartelle
    $arrayFolder = array_diff(scandir("video"), array('.', '..','.DS_Store'));
    foreach ($arrayFolder as $folder){
        echo $folder;
        echo '</br>';

        //carico il nome del gruppo sul DB
        model::addGroup($folder);
        $arrayVideo = array_diff(scandir("video/".$folder), array('.', '..','.DS_Store'));
        foreach ($arrayVideo as $video){
            echo $video;
            echo '</br>';

            //carico il video sul DB
            model::addVideo($video);
            //associo il video al gruppo sul DB
            model::associateVidGroup($video, $folder);
        }
    }
}

header('Location: panelControl.php');

?>
