<?php include('partials/menu.php'); ?>

<?php 
                //Check whether the id is set or not
                if(isset($_GET['id']))
                {
                    //Get the ID and all other details
                    //echo "Getting the Data";
                    $id = $_GET['id'];
                    //Create SQL Query to get all other details
                    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

                    //Execute the Query
                    $res2 = mysqli_query($conn, $sql2);

                    //Get the Value based on query executed
                    $row2 = mysqli_fetch_assoc($res2);

                   
                    //Get the individual Values of selected food
                        $title = $row2['title'];
                        $description = $row2['description'];
                        $price = $row2['price'];
                        $current_image = $row2['image_name'];
                        $current_category = $row2['category_id'];
                        $featured = $row2['featured'];
                        $active = $row2['active'];
                }
                else
                {
                    //Redirect to Manage Food Page
                        header('location:'.SITEURL.'admin/manage-food.php');
                }      
                       
                ?>
  <div class="main-content">
    <div class="wrapper">

        <br><br>

          <h1>Update Food</h1>

        <br><br>

          <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                    <?php 
                           if($current_image == "")
                           {
                             //Display the message
                             echo "<div class='error'>Image Not Available.</div>";
                           }
                           else
                           {
                             //Display the image
                             ?>
                             <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                             <?php
                           }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image: </td>
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

                              //if count is greater than 0, we have categories available
                              if($count>0)
                                {
                                        //we have category available
                                        while($row = mysqli_fetch_assoc($res))
                                            {
                                                //get the details of the category
                                                $category_title = $row['title'];
                                                $category_id = $row['id'];
                                                ?>
                                                <option <?php if($current_category==$category_id){echo "selected";}?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                                <?php
                                            }
                                }
                                else
                                {
                                    //we do not have category available
                                    
                                    echo "<option value='0'>No Category Available</option>";
                                
                                }

                              //2.Display on dropdown
                            ?>
                           
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";}?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No"){echo "checked";}?> type="radio" name="featured" value="No"> No
                    </td>    
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value="No"> No
                    </td>    
                </tr>
                <tr>
                    <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>


        </form>
          
        <?php

         //Check whether the Submit Button is Clicked or Not

            if(isset($_POST['submit']))
                {
                // echo "Button Clicked";
                //1.Get all the Values from Form to Update
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $current_image = $_POST['current_image'];
                    $category = $_POST['category'];

                    $featured = $_POST['featured'];
                    $active = $_POST['active'];    
               
                
                //2.Updating the new image if selected
                    if(isset($_FILES['image']['name']))
                    {
                        //Get the Image details
                        $image_name = $_FILES['image']['name']; //New image name

                        //Check whether the image is available or not
                        if($image_name != "")
                        {
                         //Image Available
                         //A. Upload the New Image

                            //AutoRename Image
                            //Get the Extention off our Image (jpg,png,gif.. e.g. ->"specialfood1.jpg")
                            $ext = end(explode('.', $image_name));

                            //Rename the Image
                            $image_name = "Food-Name-".rand(000,999).'.'.$ext; //e.g. Food-Name-171.jpg

                            //Get the Source and Destination Path

                            $src_path = $_FILES['image']['tmp_name']; //source path
                            $dest_path = "../images/food/".$image_name; //destination path

                            //Finally Upload the Image
                            $upload = move_uploaded_file($src_path,$dest_path);

                            //Check whether the image is uploaded or not
                            //And if the image is not uploaded, stop the process and redirect with error message
                                if($upload==false)
                                {
                                    //Set Message
                                    $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image</div>";
                                    //Redirect to Manage Food Page
                                    header('location:'.SITEURL.'admin/manage-food.php');
                                    //Stop the Process
                                    die();

                                }

                                //B.Remove the Current Image if Available
                                if($current_image != "")
                                {
                                    $remove_path = "../images/food/".$current_image;
                                    $remove = unlink($remove_path);
        
                                    //Check whether the Image is Removed or Not
                                    //If failed to remove, display the message and stop the process
        
                                    if($remove==false)
                                    {
                                        //Failed to remove image
                                        $_SESSION['remove-failed'] = "<div class='error'>Failed to Remove Current Image</div>";
                                        header('location:'.SITEURL.'admin/manage-food.php');
                                        die();//Stop the Process
                                    }
                                }
                            
                        }
                        else
                        {
                            $image_name = $current_image; //Default image when image is not
                        }
                       
                    }
                    else
                    {
                        $image_name = $current_image;
                    }

                    //3.Update the food in the database
                    $sql3 = "UPDATE tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = '$category',
                        featured = '$featured',
                        active = '$active'
                        WHERE id='$id'
                    ";

                    //Execute the Query

                    $res3 = mysqli_query($conn, $sql3);

                    //4.Redirect to manage category page with message

                    //Check whether the Query is Executed Successfully or Not
                    if($res3==true)
                        {
                            //Query Executed and Food Updated
                            $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                            echo "<script>window.location.href='http://localhost/food-delivery/admin/manage-food.php';</script>";       

                        }
                        else
                        {
                            //Failed to update Food
                            $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
                            echo "<script>window.location.href='http://localhost/food-delivery/admin/manage-food.php';</script>"; 
                        }
                }


          ?>

    </div>
  </div>

<?php include('partials/footer.php'); ?>