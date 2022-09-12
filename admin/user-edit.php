<?php
session_start();
require "../config/config.php";
require "../config/common.php";


if($_SESSION['role'] != 1){
    header('Location: login.php');
  }

if($_POST){
    if(empty($_POST['name']) || empty($_POST['email'] ) ){
        if(empty($_POST['name'])){
          $nameError = "Name cannot be null";
        }
        if(empty($_POST['email'])){
          $emailError = "Email cannot be null";
        }
       
    }elseif(!empty($_POST['password']) && strlen($_POST['password']) < 4 ){
        $passError = "Password should be 4 character at lease";

    }else{
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = password_hash($_POST['password'],PASSWORD_DEFAULT);
      
        // $admin = $_POST['admin'];
    
        if(empty($_POST['admin'])){
            $admin = 0;
        }else{
            $admin = 1;
        }
          $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email AND id!=:id");
          $stmt->execute(array(':email'=>$email,':id'=>$id));
          $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if($user){
            echo "<script>alert('email duplicate')</script>";
        }else{
            if($pass != null){
                $stmt = $pdo->prepare("UPDATE users SET name='$name',email='$email',password='$pass',role='$admin' WHERE id ='$id'");
            }else{
                $stmt = $pdo->prepare("UPDATE users SET name='$name',email='$email',role='$admin' WHERE id ='$id'");
            }
            $result = $stmt->execute();
            if ($result) {
                echo "<script> alert('Successfuly Update');window.location.href='userlist.php';</script>";
            }
        }
    
      }
   
        
    

}
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
    $stmt->execute();
    $result = $stmt->fetchAll();

   

    ?>

<?php require "header.php" ?>
    <div class="card">
        <div class="card-body">
            <h1>User Edit</h1>
            <form enctype="multipart/form-data" action="" method="post" >
                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>">
                <div class="form-group">
                <p style="color:red"><?php echo empty($nameError) ? '': "***".$nameError ?></p>
                    <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo escape($result[0]['name']) ?>">
                </div>
                <div class="form-group">
                <p style="color:red"><?php echo empty($emailError) ? '': "***".$emailError ?></p>
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo escape($result[0]['email']) ?>">
                </div>
                <div class="form-group">
                    <p style="color:red"><?php echo empty($passError) ? '': "***".$passError ?></p>
                    <label for="password">Password</label>
                    <span style="font-size:10px">The user aleady have password</span>
                    <input type="text" class="form-control" name="password" value="<?php echo escape($result[0]['password']) ?>">
                </div>
                
                    <label for="admin">Admin</label>
                    <input type="checkbox" class="form-control" name="admin" value="1" <?php if($result[0]['role']==1) echo "checked" ?>>
                <br>
                
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    <a href="userlist.php" type="button" class="btn btn-warning">Back</a>
                </div>
            </form>
        </div>
    </div>


    <?php require "footer.html" ?>

