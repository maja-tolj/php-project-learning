<?php 
   //Authorization - Access Control
   //Check whether the User is Logged In or Not

   if(!isset($_SESSION['user'])) //if the user session is not set
   {
      //User is not logged in
      //Redirect to Login Page with Message
      $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login To Access Admin Panel</div>"; 
       unset($_SESSION['login']); 
      //Redirect to Login Page
      header('location:'.SITEURL.'admin/login.php'); 
   } 
?>
