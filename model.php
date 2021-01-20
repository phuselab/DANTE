<?php
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);

    include 'config.php';

    $conn = new mysqli($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);

    //classe model mi contiene le connessioni al DB e altre funzioni utili lato server
    class Model{

        static function doesUserExist($id){
           global $conn;
           $stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
           $stmt->bind_param("s", $id);
           $stmt->execute();
           $result = $stmt->get_result();
           return $result;            
        }

        //Dato l'id utente ritorna i video a lui assegnati in base al gruppo di appartenenza
        static function getVideoByUsrId($id){
            global $conn;
            $stmt = $conn->prepare("SELECT videos.id, videos.name
                                    FROM videos, relgroupvideo, `groups`, users 
                                    WHERE users.id = ? AND users.fk_idgroup=groups.name AND
                                    relgroupvideo.fk_idgroup=groups.name AND
                                    relgroupvideo.fk_idvideo=videos.id
                                    ORDER BY videos.name");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result === FALSE) { 
                die(mysql_error()); // TODO: better error handling
            }
            return $result;
        }
        
        static function doesAnnotationExist($userId, $video, $type){
            if ($GLOBALS['save_mode'] == 'db') {
                global $conn;
                $stmt = $conn->prepare("SELECT COUNT(id) FROM annotation WHERE UserId= ? AND NameVideo= ? AND AnnoType= ?");
                $stmt->bind_param("sss", $userId, $video, $type);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_row();

                return $row[0];

            } elseif ($GLOBALS['save_mode'] == 'file') {
                return file_exists("annotation/".$userId."/".str_replace('.', '_', $video)."/".$type.".csv");
            }
        }
        
        static function rmOldAnnotation($userId, $video, $type){
            if ($GLOBALS['save_mode'] == 'db') {
                global $conn;
                $stmt = $conn->prepare("DELETE FROM annotation WHERE UserId= ? AND NameVideo= ? AND AnnoType= ?");
                $stmt->bind_param("sss", $userId, $video, $type);
                $stmt->execute();
            }
        }
        
        static function addAnnotation($data){
            
            $userId = $data->userId;
            $video = $data->video;
            $type = $data->type;

            if ($GLOBALS['save_mode'] == 'db') {
                global $conn;
                foreach($data->valvid as $row){

                    $stmt = $conn->prepare("INSERT INTO annotation VALUES (?,?,?,?,?,NULL);");
                    $stmt->bind_param("sssss", $row->timeStamp, $data->userId, $data->video, $data->type, $row->value);
                    $stmt->execute();
                }

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
            global $conn;
            $stmt = $conn->prepare('SELECT groups.name FROM `groups`, users WHERE users.id = ? AND users.fk_idgroup = groups.name');
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return mysqli_fetch_array($result)['name'];
        }
        
        static function getGroups(){
            global $conn;
            $result = $conn->query('SELECT * FROM `groups`;');            
            return $result;
        }

        static function getUsers() {
            global $conn;
            $result = $conn->query('SELECT * FROM users;');        
            return $result;            
        }
        
        static function addUser($name, $surname, $email, $id, $group){
            global $conn;
            $stmt = $conn->prepare('INSERT INTO users VALUES (?, ?, ?, ?, ?)');
            $stmt->bind_param("sssss", $id, $group, $name, $surname, $email);
            $stmt->execute();
        }

        static function deleteUser($id){
            global $conn;
            $stmt = $conn->prepare('DELETE FROM users WHERE id= ?');
            $stmt->bind_param("s", $id);
            $stmt->execute();
        }
        
        static function getNewUserID(){
            global $conn;
            do {
                $newId = '';

                for($i = 0; $i < 4; $i++) {
                    $newId .= mt_rand(0, 9);
                }

                $stmt = $conn->prepare('SELECT * FROM users WHERE id = ?');
                $stmt->bind_param("s", $newId);
                $stmt->execute();
                $result = $stmt->get_result();

            } while ($result->num_rows > 0);

            return $newId;
        }

        static function updateAdmin($newPwd){
            global $conn;
            $stmt = $conn->prepare('UPDATE userAdmin SET password = ? WHERE username = "admin"');
            $stmt->bind_param("s", $newPwd);
            $stmt->execute();
        }

        static function getAdmin(){
            global $conn;
            $stmt = $conn->prepare('SELECT * FROM userAdmin');
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }

        static function addGroup($folder){
            global $conn;
            $stmt = $conn->prepare('INSERT INTO `groups`(id, name) VALUES (NULL, ?);');
            $stmt->bind_param("s", $folder);
            $stmt->execute();
        }

        static function addVideo($video){
            global $conn;
            $stmt = $conn->prepare('INSERT INTO videos(id, name) VALUES (NULL, ?)');
            $stmt->bind_param("s", $video);
            $stmt->execute();
        }

	   static function associateVidGroup($video, $folder){
            global $conn;
            $stmt = $conn->prepare('SELECT id FROM videos WHERE name = ? ORDER BY id DESC LIMIT 1');
            $stmt->bind_param("s", $video);
            $stmt->execute();
            $result = $stmt->get_result();
            $idVideo = mysqli_fetch_array($result)['id'];

            $stmt1 = $conn->prepare('INSERT INTO relgroupvideo(fk_idvideo, fk_idgroup) VALUES (?, ?)');
            $stmt1->bind_param("ss", $idVideo, $folder);
            $stmt1->execute();
        }

        static function clearTables(){
            global $conn;
            $conn->query('TRUNCATE TABLE videos;');
            $conn->query('TRUNCATE TABLE `groups`;');
            $conn->query('TRUNCATE TABLE relgroupvideo;');
        }
    }
?>
