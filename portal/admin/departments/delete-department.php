<?php
    require('config.php');
    $id=$_GET['id'];
    $query="DELETE FROM department WHERE id='$id'";
    $data=mysqli_query($conn,$query);
    if  ($data){
            ?>
            <script type="text/javascript">
                alert("data delete successfully");
                header
                window.open("appointments.php","_self");
            </script>
            <?php
    }else{
        ?>
        <script type="text/javascript">
            alert("please try again")
        </script>
        <?php
    }
?>