<?php include('../config/constants.php');?>
<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
            <?php
             if(isset($_SESSION['login'])) 
             {
                 echo $_SESSION['login']; 
                 unset($_SESSION['login']); 
             } 
             if(isset($_SESSION['no-login-message'] ))
             {
                echo $_SESSION['no-login-message']; 
                unset($_SESSION['no-login-message']); 
             }
            
            ?>
            <br><br>

            <!-- Login Form Starts Here -->
            <form action="" method="POST" class="text-center">
                Username:<br>
                <input type="text" name="username" placeholder="Enter Username"><br><br>

                Password:<br>
                <input type="password" name="password" placeholder="Enter Password"><br><br>

                <input type="submit" name="submit" value="Login" class="btn-primary"><br><br>


            </form>

            
            <div>
                <p>Don't have an account! <a href="registration.php">Register</a></p><br><br>
            </div>

            <!-- Login Form Ends Here -->


            <p class="text-center" >Created By - <a href="#">Maja Tolj</a></p>

        </div>



    </body>
</html>

<?php 
     //Check whether the Submit Button is Clicked or Not
     if(isset($_POST['submit']))
     {
        //Process for Login
        //1.Get the Data from Login Form
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $password = md5($_POST['password']);
        //$hash_password = password_hash("password", PASSWORD_DEFAULT);
        

        //2.SQL to Check whether the User with Username and Password Exist or Not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3.Execute the Query
        $res = mysqli_query($conn,$sql);

        //4.Count Rows to Check whether the User Exist or Not
        $count = mysqli_num_rows($res);
        if($count==1)
        {
            //User Available and Login Success
            $_SESSION['login'] = "<div class='success'>Login Successfully.</div>";
            $_SESSION['user'] = $username; // to check whether the user is logged in or not and logout will unset it

            //Redirect to HomePage / Dashboard
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //User not Available and Login Fail
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
            //Redirect to HomePage / Dashboard
            header('location:'.SITEURL.'admin/login.php');
        }

     }

?>