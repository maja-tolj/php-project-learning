<?php 
  //Include constants file
  include('../config/constants.php');
  //echo "Delete Page";
  //Check whether the id and image_name value is set or not
  if(isset($_GET['id']) AND isset($_GET['image_name']))
  {
    //Get the Value -id and image- and Delete
    //echo "Get the Value and Delete";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //Remove the physical image file is available
    if($image_name != "")
    {
        //Image is Available, so Remove It
        $path = "../images/food/".$image_name;
        //Remove the Image
        $remove = unlink($path);
       
        //If Failed to Remove then add an error message and stop the process
        if($remove==false)
        {
            //Set the Session Message
            $_SESSION['upload'] = "<div class='error'>Failed to Remove the Image.</div>";
            //Redirect to Manage Food Page
            header('location:'.SITEURL.'admin/manage-food.php');
            //Stop the Process
            die();
        }
    }

    //Delete Data-food from the Database
    //SQL Query to Delete Data from Database
    $sql = "DELETE FROM tbl_food WHERE id=$id";

    //Execute the Query
    $res = mysqli_query($conn, $sql);

    //Check whether the data is deleted from database or not
    if($res==true)
    {
        //Set Success message and redirect
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
        //Redirect to Manage Category
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    else
    {
        //Set Fail message and redirect
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";
        //Redirect to Manage Category
        header('location:'.SITEURL.'admin/manage-food.php');
    }


  }
  else
  {
    //Redirect to Manage Food Page
    $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access</div>";
    header('location:'.SITEURL.'admin/manage-category.php');
  }

?>