<?php
session_start();
require "config/config.php";
require "config/common.php";



  if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
    header('Location: login.php');

  }

  if($_SESSION['role'] != 1){
       header('Location: login.php');
   }

  if($_POST){
    if(empty($_POST['name']) || empty($_POST['description'])){

      if(empty($_POST['name'])){
        $nameError = "name cannot be null";
      }
      if(empty($_POST['description'])){
        $descError = "Description cannot be null";
      }

    }else{

            $name = $_POST['name'];
            $desc = $_POST['description'];

            $sql = "INSERT INTO categories(name,description) VALUES (:name,:description)";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute(
              array(
                ":name" => $name,
                ":description" => $desc,
               
              
              )
            );
            if($result){
              echo "<script> alert('New category is added');window.location.href='category.php';</script>";
            }            
          
    }  
  }
?>

<?php require "header.php" ?>
    <div class="card">
        <div class="card-body">
            <h1>Create New Todo</h1>
            <form enctype="multipart/form-data" action="cat_add.php" method="post" >
                <div class="form-group">
                  <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>">
                    <label for="name">name</label><p style="color:red"><?php echo empty($nameError) ? '': "***".$nameError ?></p>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="form-group">
                    <label for="description">Description</label><p style="color:red"><?php echo empty($descError) ? '': "***".$descError ?></p>
                    <textarea name="description" class="form-control"   cols="80" rows="8"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    <a href="category.php" type="button" class="btn btn-warning">Back</a>
                </div>
            </form>
        </div>
    </div>


    <?php require "footer.html" ?>

