<?php
include_once "config.php";

 $connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if(! $connection){
    throw new Exception("Cannot connect to database"); 
}
$query = "SELECT * FROM tasks_table WHERE Complete = 0 ORDER BY Date";
$result = mysqli_query($connection,$query);

$completeTaskquery = "SELECT * FROM tasks_table WHERE  Complete = 1 ORDER BY Date";
$completeTaskResult = mysqli_query($connection,$completeTaskquery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container">
        <h1>Tasks Manager</h1>
        <p>This is a simple project for managing our daily tasks. We are going to use HTML,CSS,PHP and JAVASCRIPT for this project.
        </p>
        <?php 
        if(mysqli_num_rows($completeTaskResult) > 0){
        
           ?>
            <h4>Complete Tasks</h4>
        
             <table>
             <thead>
                 <tr>
                     <th></th>
                     <th>ID</th>
                     <th>Task</th>
                     <th>Date</th>
                     <th>Action</th>
                 </tr>
             </thead>
             <tbody>
             <?php 
             while ($cdata = mysqli_fetch_assoc($completeTaskResult) ){
                 $timestamp = strtotime($cdata['Date']);
                 $cdate = date("jS M, Y",$timestamp);
             ?>
                 <tr>
                     <td><input class="label-inline" type="checkbox" value="<?php echo $cdata['id'] ?>"></td>
                     <td><?php echo $cdata['id'] ?></td>
                     <td><?php echo $cdata['Task'] ?></td>
                     <td><?php echo $cdate ?></td>
                     <td><a class="delete" data-tdelete="<?php echo $cdata['id'] ?>" href="#">Delete</a> | <a class="incomplete" data-incomplete="<?php echo $cdata['id'] ?>" href="#">MarkIncomplete</a>  </td>

                 </tr>
             <?php }?>

             </tbody>
         </table>

        <?php 

         }
        ?>


        <?php
        if(mysqli_num_rows($result)==0){
            ?>
            <p>No tasks Found</p>
            <?php
        }else {
            ?>
            <p> Upcoming Tasks</p>
            <form action="tasks.php" method="POST">
            <input type="hidden" name="action" value="bulkcomplete">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Task</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                while ($data = mysqli_fetch_assoc($result) ){
                    $timestamp = strtotime($data['Date']);
                    $date = date("jS M, Y",$timestamp);
                ?>
                    <tr>
                        <td><input name="taskids[]" class="label-inline" type="checkbox" value="<?php echo $data['id'] ?>"></td>
                        <td><?php echo $data['id'] ?></td>
                        <td><?php echo $data['Task'] ?></td>
                        <td><?php echo $date ?></td>
                        <td> <a class="delete" data-tdelete="<?php echo $data['id'] ?>" href="#">Delete</a> | <a class="complete" data-taskid="<?php echo $data['id'] ?>" href="#">Complete</a> </td>
                    </tr>
                <?php }?>

                </tbody>
            </table>
        <select id="bulkaction" name="action">
            <option value="0">With Selected</option>
            <option value="bulkdelete"> Delete</option>
            <option value="bulkcomplete">Mark as Complete</option>
                    
        </select>
        <input class="button-primary" id="bulksubmit" type="submit" value="Submit">
        </form>
        <?php }?>




        <p>...</p>
        <h4>Add Tasks</h4>
        <form method="post" action="tasks.php">
            <fieldset>
            <?php
            $added = $_GET['added'] ?? '';
            if($added){
                echo '<p>Task successfully added</p>';
            }
            
            ?>
                <label for="task">Task</label>
                <input type="text" placeholder="Task Details" id="task" name="task">
                <label for="date">Date</label>
                <input type="text" placeholder="Task Date" id="date" name="date">
                <input class="button-primary" type="submit" value="Add Task">
                <input type="hidden" name="action" value="add">


            </fieldset>
        </form>
       
    </div>
  <form action="tasks.php" method="post" id="completeform">
            <input type="hidden" name="action" value="complete">
            <input type="hidden" id="taskid" name="taskid">
  </form>
  <form action="tasks.php" method="post" id="deleteform">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" id="tdelte" name="taskid">
  </form>
  <form action="tasks.php" method="post" id="incompleteform">
            <input type="hidden" name="action" value="incomplete">
            <input type="hidden" id="incomplete" name="incomplete">
  </form>
</body>
<script src="jquery.js"></script>
<script>
;(function($){
    $(document).ready(function(){
        $(".complete").on('click',function(){
            var id = $(this).data("taskid");
           $("#taskid").val(id);
           $("#completeform").submit();
      });

      $(".delete").on('click',function(){
          if(confirm("Are you sure to delete this task?")){
            var id = $(this).data("tdelete");
           $("#tdelte").val(id);
           $("#deleteform").submit();
          }
      });
      $(".incomplete").on('click',function(){
        var id = $(this).data("incomplete");
        $("#incomplete").val(id);
        $("#incompleteform").submit();
      });

      $("#bulksubmit").on('click',function(){
        if($("#bulkaction").val() == 'bulkdelete'){
            if(!confirm("Are you sure to delete?")){
                return false;
            }
        }
      });


    });
})(jQuery);
</script>
</html>