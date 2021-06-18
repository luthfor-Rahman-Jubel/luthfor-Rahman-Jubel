<?php 
include_once "config.php";

$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if(! $connection){
    throw new Exception("Cannot connect to database"); 
}else{
    echo "Connected";
    //echo mysqli_query($connection," INSERT INTO tasks_table (Task,Date) VALUES ( 'Bring medicine for Dad','2020-07-17' ) ");
   // $result = mysqli_query($connection,"SELECT * FROM tasks_table");
   // while ($data = mysqli_fetch_object($result)) {
    //    echo "<pre>";
    //    print_r($data);
     //   echo "</pre>";
    //}
}

?>