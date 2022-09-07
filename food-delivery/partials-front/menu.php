<?php include('config/constants.php')?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <!-- Important to make website responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Food Website</title>
        
        <!-- Link CSS File -->
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        
        <?php

            if(isset($_SESSION['login'])) 
            {
                echo $_SESSION['login']; 
                unset($_SESSION['login']); 
            }  
        ?>
    
        <!-- Navbar Section Starts Here -->
        <header>
            
            <nav class="navbar">
                
                    <a href="#" class="nav-branding">
                        Maia'S
                    </a>

                        <ul class="nav-menu">
                            <li class="nav-item">
                                <a href="<?php echo SITEURL;?>" class="nav-link">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo SITEURL;?>categories.php" class="nav-link">Categories</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo SITEURL;?>foods.php" class="nav-link">Foods</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo SITEURL;?>" class="nav-link">Contact</a>
                            </li>
                        </ul>
                    <div class="hamburger">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </div>

                    </div>
             
            </nav>
        </header>
        <script src="script.js"></script>

         <!-- Navbar Section Ends Here -->