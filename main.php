<?php 
    $errorMsg = "";

    //connect to db
    require_once("dbinfo.php"); //all db info defined in this file
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      exit;
    }

    //puts all url data from db into urls[] and then redirect based on values in urls[]
    $urls = array();
    $sql = "SELECT * FROM `urls`";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        if($row["shortUrl"] == $_SERVER["REQUEST_URI"]){
            header("Location: " . $row["originUrl"]);
        }
        $urls[count($urls)] = array($row["id"], $row["originUrl"], $row["shortUrl"]);
      }
    }

    // inserts link data into db 
    function insertLink($originUrl, $shortUrl){
        global $conn;
        $sql = " INSERT INTO `urls`(`originUrl`, `shortUrl`) VALUES (\"{$originUrl}\", \"/{$shortUrl}\") ";
        $conn->query($sql);
    }
    if(isset($_POST["shortUrl"]) && isset($_POST["originUrl"])){

        $isValid = false;
        foreach($urls as $url){
            if(strcmp($url[2], "/" . $_POST["shortUrl"]) === 0){
               $isValid = false;
               break;
            }else{
               $isValid = true;
            }
       }


       if( strcmp($_POST["originUrl"], "http://s.ssingh.net/" . $_POST["shortUrl"]) === 0){
            $isValid = false; 
       }
       if($isValid === true){
            insertLink($_POST["originUrl"], $_POST["shortUrl"]);    
            $errorMsg = "Link Created: <a href='{$_POST['originUrl']}'>{$_POST['originUrl']}</a> shortened to <a href='http://s.ssingh.net/{$_POST['shortUrl']}' id='finalLink'> http://s.ssingh.net/{$_POST['shortUrl']}</a>";
            //copyToClipboard("http://s.ssingh.net/{$_POST['shortUrl']}");
                      
       }else{
            $errorMsg = "The short link <i>s.ssingh.net/{$_POST["shortUrl"]}</i> already exists, try something else.";
       }

    }
    

    //if short link doesn't exist throw error
    if($_SERVER["REQUEST_URI"] != "/"){
        $errorMsg =  "<br />link not found, but you can create one";
    }
?>