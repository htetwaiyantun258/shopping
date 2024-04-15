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
   
    if(empty($_POST['name']) || empty($_POST['description']) || empty($_POST['category']) 
    || empty($_POST['quantity']) || empty($_POST['price']) || empty($_FILES['image'])){

      if(empty($_POST['name'])){
        $nameError = "name cannot be null";
      }
      if(empty($_POST['description'])){
        $descError = "Description cannot be null";
      }
      if(empty($_POST['category'])){
        $catError = "Category cannot be null";
      }
      if(empty($_POST['quantity'])){
        $qtyError = "Quantity cannot be null";
      }elseif(is_numeric($_POST['quantity']) != 1){
        $qtyError = "Quantity should be integer value";
      }
      if(empty($_POST['price'])){
        $priceError = "Price cannot be null";
      }elseif(is_numeric($_POST['price']) != 1){
        $priceError = "Price should be integer value";
      }
      if(empty($_FILES['image'])){
        $fileError = "File cannot be null";
      }
      

    }else{
        if($_FILES['image']['name'] != null){

          $file = 'images/'. ($_FILES['image']['name']);
          $imgType = pathinfo($file,PATHINFO_EXTENSION);

          if($imgType != 'jpg' && $imgType != 'png' && $imgType != 'jpeg'){
            echo "<script>alert('should be png,jpg and jpeg'</script>";

          }else{
            $name = $_POST['name'];
            $description = $_POST['description'];
            $category = $_POST['category'];

            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $image = $_FILES['image']['name'];
            $id = $_POST['id'];

            move_uploaded_file($_FILES['image']['tmp_name'], $file);


            $stmt = $pdo->prepare("UPDATE products SET name=:name, description=:description,category_id=:category_id,
                                                      quantity=:quantity,price=:price,image=:image WHERE id=:id");
            $result = $stmt->execute(
                array(
                    ":name" => $name,
                    ":description" => $description,
                    ":category_id" => $category,
                    ":quantity"=>$quantity,
                    ":price" => $price,
                    ":image" => $image,
                    ":id"=>$id,
                    )
            );
            if ($result) {
                echo "<script> alert('New Products is added');window.location.href='index.php';</script>";
            }
          }
        }else{
          $name = $_POST['name'];
                $description = $_POST['description'];
                $category = $_POST['category'];

                $quantity = $_POST['quantity'];
                $price = $_POST['price'];



                $stmt = $pdo->prepare("UPDATE products SET name=:name, description=:description,category_id=:category_id,
                                              quantity=:quantity,price=:price WHERE id=:id");
                $result = $stmt->execute(
                    array(
                        ":name" => $name,
                        ":description" => $description,
                        ":category_id" => $category,
                        ":quantity"=>$quantity,
                        ":price" => $price,
                        ":id"=>$id,
                        )
                );
              if ($result) {
                  echo "<script> alert('New Products is added');window.location.href='index.php';</script>";
              }

        }      
      } 
  }

  $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
  $stmt->execute();
  $result= $stmt->fetchAll();
?>

<?php require "header.php" ?>
    <div class="card">
        <div class="card-body">
            <h1>Product Add</h1>
            <form enctype="multipart/form-data" action="" method="post" >
                <div class="form-group">
                  <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>">
                  <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
                    <label for="name">name</label><p style="color:red"><?php echo empty($nameError) ? '': "***".$nameError ?></p>
                    <input type="text" class="form-control" name="name" value="<?php echo escape($result[0]['name']) ?>">
                </div>
                <div class="form-group">
                    <label for="description">Description</label><p style="color:red"><?php echo empty($descError) ? '': "***".$descError ?></p>
                    <textarea name="description" class="form-control"   cols="80" rows="5"><?php echo escape($result[0]['description']) ?></textarea>
                </div>
                <div class="form-group">
                    <?php
                        $cat_stmt = $pdo->prepare("SELECT * FROM categories");
                        $cat_stmt->execute();
                        $catResult= $cat_stmt->fetchAll();
                    ?>
                    <label for="category">Category</label><p style="color:red"><?php echo empty($catError) ? '': "***".$catError ?></p>
                    <select name="category" id="" class="form-control">
                      <option value="">SELECT CATEGORY</option>
                        <?php foreach($catResult as $catValue){ ?>
                          <?php if($catValue['id'] == $result[0]['category_id']):?>
                            <option value="<?php echo $catValue['id'];  ?>" selected name="category"><?php echo $catValue['name']; ?> </option>
                          <?php else: ?>
                            <option value="<?php echo $catValue['id'];  ?>" name="category"><?php echo $catValue['name']; ?> </option>
                          <?php endif ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label><p style="color:red"><?php echo empty($qtyError) ? '': "***".$qtyError ?></p>
                    <input type="number" class="form-control" name="quantity" value="<?php echo escape($result[0]['quantity']) ?>">
                </div>
                <div class="form-group">
                    <label for="price">Price</label><p style="color:red"><?php echo empty($priceError) ? '': "***".$priceError ?></p>
                    <input type="number" class="form-control" name="price" value="<?php echo escape($result[0]['price']) ?>">
                </div>
                <div class="form-group">
                    <label for="image">Upload Image</label><p style="color:red"><?php echo empty($fileError) ? '': "***".$fileError ?></p>
                    <img src="images/<?php echo $result[0]['image'] ?>" alt="" srcset="" style="width:300px; height:300px;"><br><br>
                    <input type="file"  name="image">
                </div>
                
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    <a href="index.php" type="button" class="btn btn-warning">Back</a>
                </div>
            </form>
        </div>
    </div>
<?php require "footer.html" ?>

