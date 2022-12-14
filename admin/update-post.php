<?php include "header.php"; 
$user_id = $_GET['user_id'];
include'config.php';
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
        <form action="save-update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <?php 
            if($_SESSION['user_role'] == 0 && $_SESSION['user_id'] == $user_id)
            {
            include'config.php';
            $post_id = $_GET['id'];
            $sql = "SELECT * FROM post 
                     LEFT JOIN category ON post.category = category.category_id
                     LEFT JOIN user ON post.author = user.user_id WHERE post_id = {$post_id}";
                   }
                   elseif($_SESSION['user_role'] == 1){
                     include'config.php';
                     $post_id = $_GET['id'];
                      $sql = "SELECT * FROM post 
                     LEFT JOIN category ON post.category = category.category_id
                     LEFT JOIN user ON post.author = user.user_id WHERE post_id = {$post_id}";
                   } else{

                    header("Location: http://localhost/blog-site/admin/post.php");
                   }

                     $result = mysqli_query($conn, $sql) or die ("Query Failed");
                    if(mysqli_num_rows($result) > 0 ){
                        while($row = mysqli_fetch_assoc($result))
                    
                  {?>
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $row['post_id'] ?>" placeholder="">
                <input type="hidden" name="old_category" value = "<?php echo $_GET['cat_id'] ;?>"> 
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $row['title'] ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5">
                    <?php echo $row['description'] ?>
                </textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <select class="form-control" name="category">
                  <?php
                  include 'config.php';
                    $sql1 = "SELECT * FROM category" ;
                  $result1 = mysqli_query($conn, $sql1) or die("Query Failed");
                    if(mysqli_num_rows($result1) > 0){
                      while($row1 = mysqli_fetch_assoc($result1)){
                       if($row['category'] == $row1['category_id'] ){
                        $selected = "selected";
                       }else{
                        $selected = '';
                       }
                     echo "<option {$selected} value ='{$row1['category_id']}' >{$row1['category_name']}</option>";
                      }
                  }?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image">
                <img  src="upload/<?php echo $row['post_img'] ?>"height="150px">
                <input type="hidden" name="old_image" value="<?php echo $row['post_img'] ;?>">
                
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
            <?php
        }
    }


             ?>
        </form>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
