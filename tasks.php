<?php 

include_once "config.php";

$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if(! $connection){
    throw new Exception("Cannot connect to database");
}else {

    $action = $_POST['action'] ?? '';

    if(! $action){
        header('Location: index.php');
        die();
    }else {
        if ('add' == $action) {
           $task = $_POST['task'];
           $date = $_POST['date'];
           if($task && $date){
               $query = "INSERT INTO ".DB_TABLE."(Task,Date) VALUES('{$task}','{$date}') ";
               mysqli_query($connection,$query);
               header('Location: index.php?added=true');
           }
        }elseif ('complete' == $action) {
            $taskid = $_POST['taskid'];
            if($taskid){
            $query = "UPDATE tasks_table SET Complete=1 WHERE id={$taskid} LIMIT 1";
                mysqli_query($connection,$query);
               
            }
            header('Location: index.php');
        }elseif ('delete' == $action) {
            $taskid = $_POST['taskid'];
            if($taskid){
            $query = "DELETE FROM tasks_table WHERE id={$taskid} LIMIT 1";
                mysqli_query($connection,$query);
               
            }
            header('Location: index.php');
        }elseif ('incomplete' == $action ) {
          $incomplete = $_POST['incomplete'];
          if($incomplete){
              $query = "UPDATE tasks_table SET Complete=0 WHERE id={$incomplete} LIMIT 1";
              mysqli_query($connection,$query);
          }
          header('Location: index.php');
        }elseif ('bulkcomplete' == $action) {
            $taskids = $_POST['taskids'];
            $_taskids = join(",",$taskids);
            if($taskids){
                $query = "UPDATE tasks_table SET Complete=1 WHERE id in ($_taskids) ";
                mysqli_query($connection,$query);
            }
            header('Location: index.php');
        }elseif ('bulkdelete' == $action) {
            $taskids = $_POST['taskids'];
            $_taskids = join(",",$taskids);
            if($taskids){
                $query = "DELETE FROM tasks_table WHERE id in ($_taskids) ";
                mysqli_query($connection,$query);
            }
            header('Location: index.php');
        }



    }
    
    
}
mysqli_close($connection);



?>