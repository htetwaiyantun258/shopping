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
            $id = $_POST['id'];

            $stmt = $pdo->prepare("UPDATE categories SET name=:name, description=:description WHERE id=:id");
            $result = $stmt->execute(
              array(
                ":name" => $name,
                ":description" => $desc,
                ":id" => $id
              
              )
            );
            if($result){
              echo "<script> alert('Update category is successfully updated');window.location.href='category.php';</script>";
            }            
          
    }  
  }
  $stmt = $pdo->prepare("SELECT * FROM categories WHERE id=".$_GET['id']);
  $stmt->execute();
  $result= $stmt->fetchAll();
 
?>

<?php require "header.php" ?>
    <div class="card">
        <div class="card-body">
            <h1>Create New Todo</h1>
            <form enctype="multipart/form-data" action="cat_edit.php" method="post" >
                <div class="form-group">
                  <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>">
                  <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
                    <label for="name">Name</label><p style="color:red"><?php echo empty($nameError) ? '': "***".$nameError ?></p>
                    <input type="text" class="form-control" name="name" value="<?php echo $result[0]['name']?>">
                </div>
                <div class="form-group">
                    <label for="description">Description</label><p style="color:red"><?php echo empty($descError) ? '': "***".$descError ?></p>
                    <textarea name="description" class="form-control"   cols="80" rows="8"><?php echo $result[0]['description']?></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    <a href="category.php" type="button" class="btn btn-warning">Back</a>
                </div>
            </form>
        </div>
    </div>


    <?php require "footer.html" ?>

