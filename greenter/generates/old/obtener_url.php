    <?php 

    $DateAndTime = date('m-d-Y h:i:s a', time());  
    echo "The current date and time are $DateAndTime.";
    echo "<br>";
    
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    
    $url="https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    
    $rutabase= dirname($url) . DIRECTORY_SEPARATOR; 
    
    echo dirname(__FILE__) . DIRECTORY_SEPARATOR . "<br>"; 
    echo $rutabase . "<br>"; 
    ?>
