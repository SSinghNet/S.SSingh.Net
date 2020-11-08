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
       if($isValid === true){
            insertLink($_POST["originUrl"], $_POST["shortUrl"]);    
            $errorMsg = "Link Created: <a href='{$_POST['originUrl']}'>{$_POST['originUrl']}</a> shortened to <a href='http://short.ssingh.net/{$_POST['shortUrl']}'> short.ssingh.net/{$_POST['shortUrl']}</a>";              
       }else{
            $errorMsg = "The short link <i>short.ssingh.net/{$_POST["shortUrl"]}</i> already exists, try something else.";
       }

    }
    

    //if short link doesn't exist throw error
    if($_SERVER["REQUEST_URI"] != "/"){
        $errorMsg =  "<br />link not found, but you can create one";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Short.SSingh.Net</title>
    </head>
    <body>
        <center>
            <h1>Short.SSingh.Net</h1>
            <form action="/" method="post">
                <h3>Original Url: (follow https://website.com/ format)</h3><br/>
                <input type="text" name="originUrl" required pattern="https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)" value="<?php echo $_POST['originUrl']; ?>"> <br/>

                <h3>Short Url: (alphanumeric characters only)</h3><br/>
                <p>short.ssingh.net/<input type="text" name="shortUrl" required pattern="[a-zA-Z0-9/]+" value="<?php echo $_POST['shortUrl']; ?>"></p> <br />

                <button>create</button>
            </form>
            <h1><?php echo $errorMsg ?></h1>
        </center>
        
    </body>
</html>
<?php 
    $conn->close(); 
?>