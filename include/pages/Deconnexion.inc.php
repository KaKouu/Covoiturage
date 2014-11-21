<?php 
if(isset($_SESSION['PersIdentifiee']))
{
    session_destroy();
    header("location:index.php?page=0");
}
?>