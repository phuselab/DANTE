<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

    include 'config.php';
    
    //classe model mi contiene le connessioni al DB e altre funzioni utili lato server
    class Model{

        static function doesUserExist($id){
           $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
           $query = 'SELECT id FROM users WHERE id="'. $id . '"';
            
           $result = mysqli_query($conn, $query);
           mysqli_close($conn);
            
           return $result;            
        }

        //Dato l'id utente ritorna i video a lui assegnati in base al gruppo di appartenenza
        static function getVideoByUsrId($id){
            $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
            $query ='SELECT 
                        videos.id, videos.name
                    FROM 
                        videos, relgroupvideo, groups, users  
                    WHERE 
                        users.id='.$id.' AND
                        users.fk_idgroup=groups.name AND
                        relgroupvideo.fk_idgroup=groups.name AND
                        relgroupvideo.fk_idvideo=videos.id
                    ORDER BY videos.name';
            $risultato = mysqli_query($conn, $query);

            if($risultato === FALSE) { 
                die(mysql_error()); // TODO: better error handling
            }
            mysqli_close($conn);
            return $risultato;
        }
        
       
        static function doesAnnotationExist($userId, $video, $type){
            if ($GLOBALS['save_mode'] == 'db') {

                $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
                $query = 'SELECT COUNT("id") FROM annotation WHERE UserId="'.$userId.'" AND NameVideo="'.$video.'" AND AnnoType="'.$type.'"';
                
                $result = mysqli_query($conn, $query);
                $row = $result->fetch_row();
                mysqli_close($conn);

                return $row[0];

            } elseif ($GLOBALS['save_mode'] == 'file') {
                return file_exists("annotation/".$userId."/".str_replace('.', '_', $video)."/".$type.".csv");
            }
        }
        
        static function rmOldAnnotation($userId, $video, $type){
            if ($GLOBALS['save_mode'] == 'db') {
                //$mydebug = fopen("debug.txt", "w") or die("Unable to open file!");

                $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
                $query = 'DELETE FROM annotation WHERE UserId="'.$userId.'" AND NameVideo="'.$video.'" AND AnnoType="'.$type.'"';
                
                mysqli_query($conn, $query);
                
                mysqli_close($conn);
				//fwrite($mydebug, $query);
            }
        }
        
        static function addAnnotation($data){
            
            $userId = $data->userId;
            $video = $data->video;
            $type = $data->type;

            if ($GLOBALS['save_mode'] == 'db') {
                
                $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);

                //$mydebug = fopen("debug.txt", "w") or die("Unable to open file!");

                foreach($data->valvid as $row){
                    $query='INSERT INTO annotation VALUES ("'.$row->timeStamp.'","'.$data->userId.'","'.$data->video.'","'.$data->type.'","'.$row->value.'",NULL);';
                    mysqli_query($conn, $query);
                    //fwrite($mydebug, $query);
                }

                mysqli_close($conn);

            } else {
            	$video = str_replace('.', '_', $video);

                if (!file_exists("annotation/".$userId."/".$video)) {
                    mkdir("annotation/".$userId."/".$video, 0777, true);
                }
                
                $myfile = fopen("annotation/".$userId."/".$video."/".$type.".csv", "w");

                if (!$myfile) {
                    header('HTTP/1.0 403 Forbidden');
                    die("Unable to open file!");
                }

                fwrite($myfile,"TimeStamp;UserId;NameVideo;AnnoType;Value\n");
                
                foreach($data->valvid as $row){
                    fwrite($myfile, $row->timeStamp.";".$userId.";".$video.";".$type.";".$row->value."\n");
                }
            }
        }
        
        static function getGroupFromId($id){
            $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
            $query = 'SELECT groups.name FROM groups, users WHERE users.id = '.$id.' AND users.fk_idgroup=groups.name';
            $result = mysqli_query($conn, $query);
            mysqli_close($conn);
            return (mysqli_fetch_array($result)['name']);
        }
        
        static function getGroups(){
            $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
            $query = 'SELECT * FROM groups;';
            $result = mysqli_query($conn, $query);
            mysqli_close($conn);
            return $result;
        }

        static function getUsers() {
            $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
            $query = 'SELECT * FROM users;';
            $result = mysqli_query($conn, $query);
            mysqli_close($conn);
            return $result;            
        }
        
        static function addUser($name, $surname, $email, $id, $group){
            $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
            $query = 'INSERT INTO users VALUES ('.$id.', "'.$group.'", "'.$name.'", "'.$surname.'", "'.$email.'");';
            mysqli_query($conn, $query);
            mysqli_close($conn);
        }

        static function deleteUser($id){
            $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
            $query = 'DELETE FROM users WHERE id="'.$id.'"';
            mysqli_query($conn, $query);
            mysqli_close($conn);
        }
        
        static function getNewUserID(){
            do {
                $newId = '';

                for($i = 0; $i < 4; $i++) {
                    $newId .= mt_rand(0, 9);
                }

                $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
                $query = 'SELECT * FROM users WHERE id = "'. $newId .'";';
                $result = mysqli_query($conn, $query);

            } while ($result->num_rows > 0);

            return $newId;
        }

        static function updateAdmin($newPwd){
            $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
            $query = 'UPDATE userAdmin SET password = "' . $newPwd . '" WHERE username = "admin";';
            mysqli_query($conn, $query);
            mysqli_close($conn);
        }

        static function getAdmin(){
            $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
            $query = 'SELECT * FROM userAdmin';
            $result = mysqli_query($conn, $query);
            mysqli_close($conn);
            return $result;
        }

        static function addGroup($folder){
            $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
            $query = 'INSERT INTO groups (id, name) VALUES (null, "'.$folder.'");';
            mysqli_query($conn, $query);
            mysqli_close($conn);
        }

        static function addVideo($video){
            $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
            $query = 'INSERT INTO videos (id, name) VALUES (null, "'.$video.'");';
            mysqli_query($conn, $query);
            mysqli_close($conn);
        }

	static function associateVidGroup($video, $folder){
            $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
            $query1 = 'SELECT id FROM videos WHERE name="'.$video.'" ORDER BY id DESC LIMIT 1;';
            $idVideo = mysqli_fetch_array(mysqli_query($conn, $query1))['id'];
            //$query2 = 'SELECT name FROM groups WHERE name="'. $folder . '" ORDER BY name DESC LIMIT 1;';
            //$nameGroup = mysqli_fetch_array(mysqli_query($conn, $query2))['name'];

            $query3 = 'INSERT INTO relgroupvideo(fk_idvideo, fk_idgroup) VALUES ('.$idVideo.',"'.$folder.'");';
            mysqli_query($conn, $query3);
            mysqli_close($conn);
        }

        static function clearTables(){
            $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
            $query1 = 'TRUNCATE TABLE videos;';
            $query2 = 'TRUNCATE TABLE groups;';
            $query3 = 'TRUNCATE TABLE relgroupvideo;';

            mysqli_query($conn, $query1);
            mysqli_query($conn, $query2);
            mysqli_query($conn, $query3);
            
            mysqli_close($conn);
        }
    }
?>
