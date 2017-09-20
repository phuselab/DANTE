<?php
    //Questo file sta sul server, viene chiamato dal client quando il video è terminato.
    //Gli viene consegnato il file json 'data' che contiene le informazioni riguardante 
    //l'utente, il video visto e per ogni istante di tempo il valore della slidebar. 
    //Questo script ricerca/crea la cartella dedicata all'utente e al video appena visto, 
    //crea un file csv che riporta il tipo di video analizzato e crea una tabella csv con il seguente formato:
    //TimeStamp - UserId - NameVideo - TypeVideo - Value
    include 'model.php';

    if(isset($_POST['data'])){
        $data = json_decode(stripslashes($_POST['data']));
        
        $userId = $data->userId;
        $video = $data->video;
        $type = $data->type;

        if (Model::doesAnnotationExist($userId, $video, $type)) {
            Model::rmOldAnnotation($userId, $video, $type);
        }

        Model::addAnnotation($data);

    }
      
?>