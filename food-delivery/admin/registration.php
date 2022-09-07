<?php include('../config/constants.php');



    if (isset($_POST['submit'])) {
        $full_name = mysqli_real_escape_string($conn, $_POST['full-name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $confirm_password = mysqli_real_escape_string($conn, md5($_POST['password']));
       

        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_admin WHERE username ='{$username}'")) > 0) 
        { 
            $_SESSION['login'] = "<div class='error text-center'>Username Is Already Used.</div>";
            
            header('location:'.SITEURL.'admin/login.php');
        } 
        else 
        {
            if ($password === $confirm_password) {
                $sql = "INSERT INTO tbl_admin (full_name, username, password) VALUES ('{$full_name}','{$username}', '{$password}')";
                $result = mysqli_query($conn, $sql);

                header('location:'.SITEURL.'admin/login.php');
    
            }
        }
    }
?>


<html>

<head>
    <title>Register Form </title>
    <link rel="stylesheet" href="../css/admin.css">
 
</head>

<body>
<div class="login">
            <h1 class="text-center">Register</h1><br><br>
                
                        <form action="" method="post" class="text-center">
                            <input type="text" name="full-name" placeholder="Enter Your Name" required><br><br>
                            <input type="text" name="username" placeholder="Enter Your Userame" value="<?php if (isset($_POST['submit'])) { echo $username; } ?>" required><br><br>                        
                            <input type="password"  name="password" placeholder="Enter Your Password" required><br><br>
                            <input type="password"  name="confirm_password" placeholder="Enter Your Confirm Password" required><br><br>
                            <input type="submit" name="submit" value="Register" class="btn-primary"><br><br>
                        </form>
                        <div>
                            <p>Have an account! <a href="login.php">Login</a>.</p><br><br>
                        </div>
                        
                        <p class="text-center" >Created By - <a href="#">Maja Tolj</a></p>
                    </div>
                </div>
            </div>

</body>

</html>




