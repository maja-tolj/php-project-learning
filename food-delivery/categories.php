<?php include('partials-front/menu.php');?>



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                  //Create SQL query to display categories from the database that are active
                  $sql = "SELECT * FROM tbl_category WHERE active='Yes' ";
                  //Execute the Query
                  $res = mysqli_query($conn,$sql);

                  //Count the Rows to check whether the category is available or not
                  $count = mysqli_num_rows($res);


                  //Check whether we have data in database or not
                  if($count>0)
                    {
                        //Categories available
                        //Get the data and display
                        while($row=mysqli_fetch_assoc($res))
                            {
                             //get the values like id, title, image_name
                             $id=$row['id'];
                             $title=$row['title'];
                             $image_name=$row['image_name'];
                             ?>

                            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                                <div class="box-3 float-container">
                                    <?php 
                                    //Check whether image is available or not
                                      if($image_name=="")
                                      {
                                         //Display Message
                                         echo "<div class='error'>Image Not Available</div>";
                                      }
                                      else
                                      {
                                        //Image Available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>"class="img-responsive img-curve">
                                        <?php
                                      }
                                    ?>
                                    <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                </div>
                            </a>

                             <?php
                                        
                            }
                            
                    }  
                    else
                    {
                       //Categories not Available
                       echo "<div class=''error>Category Not Added</div>";
                    } 
                  ?>
            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


    <?php include('partials-front/footer.php');?>