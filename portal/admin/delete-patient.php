<?php
    require('config.php');
    $id=$_GET['id'];
    $query="DELETE FROM patient WHERE id='$id'";
    $data=mysqli_query($conn,$query);
    if  ($data){
            ?>
            <script type="text/javascript">
                alert("data delete successfully");
                window.location.href='doctors.php';
                
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