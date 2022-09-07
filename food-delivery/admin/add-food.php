<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>
        <?php 
            if(isset($_SESSION['upload'])) 
            {
                echo $_SESSION['upload']; 
                unset($_SESSION['upload']); 
            } 
        ?>

        <!-- Add Food Form Starts -->

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Food Title">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Food Description"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php 
                              //Create PHP Code to Display categories from Database
                              //1.Create SQL to get all active categories from database
                              $sql = "SELECT * FROM tbl_category WHERE active='YES'";

                              //Executing Query
                              $res = mysqli_query($conn, $sql);

                              //Count rows to check whether we have categories or not
                              $count = mysqli_num_rows($res);

                              //if count is greater than 0, we have categories

                              if($count>0)
                              {
                                //we have category
                                while($row = mysqli_fetch_assoc($res))
                                {
                                    //get the details of the category
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                    <?php
                                }
                              }
                              else
                              {
                                //we do not have category
                                ?>
                                <option value="0">No Category Found</option>
                                <?php
                              }

                              //2.Display on dropdown
                            ?>
                           
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>    
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>    
                </tr>
                <tr>
                    <td colspan="2">
                    <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>


        </form>
        <!-- Add Food Form Ends -->
        <?php

                //Check whether the Submit Button is Clicked or Not
                if(isset($_POST['submit']))
                {
                    //Add the Food in Database
                    //echo "Clicked";

                    //1. Get the Data from  Form
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $category = $_POST['category'];
                    

                    //For Radio Input, we need to check whether the button is selected or not
                        if(isset($_POST['featured']))
                            {
                                //Get the Value from the Form
                                $featured = $_POST['featured'];
                            }
                            else
                            {
                                //Set the Default Value
                                $featured = "No";
                            }
                        if(isset($_POST['active']))
                            {
                                //Get the Value from the Form
                                $active = $_POST['active'];
                            }
                            else
                            {
                                //Set the Default Value
                                $active = "No";
                            }

                    
                    //Check whether the image is selected or not and set the value for image name accordingly
                    //print_r($_FILES['image']);

                    //die(); //Break the code here
                    //2.Upload the image if selected
                   
                    if(isset($_FILES['image']['name']))
                    {
                        //get the details of the selected image
                        $image_name = $_FILES['image']['name'];

                         //check whether the select image is clicked or not and upload the image only if it is selected
                           if($image_name!="")
                           {
                            //Image is selected
                            //A.rename the image
                            //get the estention of the selected image
                            $ext = end(explode('.', $image_name));

                            //Create new name for image
                            $image_name = "Food-Name-".rand(0000,9999).'.'.$ext;


                            //B.upload the image

                            $src = $_FILES['image']['tmp_name'];

                            $dst = "../images/food/".$image_name;

                            $upload =move_uploaded_file($src, $dst);

                            if($upload==false)
                            {
                                $_SESSION['upload'] = "<div class='error'>Failed to Upload the Image.</div>";
                                header('location:'.SITEURL.'admin/add-food.php');

                                die();
                            }

                           }
                          
                    }
                    else
                    {
                        //Don't upload the Image and set the image_name value as blank
                        $image_name = "";
                    }

                        //3.Insert into Database
                        //Create SQL query to save or add food
                        //for numerical we do not need to pass value inside quotes '', for string we do
                        $sql2 = "INSERT INTO tbl_food SET
                            title = '$title',
                            description = '$description',
                            price = $price,
                            image_name = '$image_name',
                            category_id = $category, 
                            featured = '$featured',
                            active = '$active'
                            ";

                        //Execute query
                        $res2 = mysqli_query($conn, $sql2);

                    //4.Redirect with Message to Manage Food Page
                    //check whether data is inserted or not
                    if($res2 == true)
                    {
                        //Query Executed and data inserted 
                        $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                        //Redirect to Manage Category Page
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                    else
                    {
                        //Failed to Add food
                        $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                        //Redirect to Manage Category Page
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }

                }
                
                ?>

    </div>
</div>
<?php include('partials/footer.php'); ?>