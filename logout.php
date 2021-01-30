<?php 
session_start();
unset( $_SESSION['user_details'] );
echo "<script>window.location.href='login';</script>";
?>