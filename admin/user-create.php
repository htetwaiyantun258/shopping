<?php
session_start();
require "../config/config.php";
require "../config/common.php";


if($_SESSION['role'] != 1){
    header('Location: login.php');
  }

if($_POST){
    if(empty($_POST['name']) || empty($_POST['email'] || empty($_FILES['password'])) || strlen($_POST['password']) < 4){
        if(empty($_POST['name'])){
          $nameError = "Name cannot be null";
        }
        if(empty($_POST['email'])){
          $emailError = "Email cannot be null";
        }
        if(empty($_FILES['password'])){
          $passError = "Password cannot be null";
        }
        if(strlen($_POST['password']) < 4){
            $passError = "Password should be 4 character at lease";
          }
      }else{
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
        // $admin = $_POST['admin'];

        if(empty($_POST['role'])){
            $role = 0;
        }else{
            $role = 1;
        }

    // $stmt = $pdo->prepare("SELECT * FROM users WHERE email =:email ");
    // $stmt->bindValue(":email",$email);
    // $stmt->execute();
    // $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("INSERT INTO users(name,email,password,role) VALUES (:name,:email,:password,:admin) ");
        $result = $stmt->execute(
            array(':name'=>$name,':email'=>$email,':password'=>$password,':admin'=>$role)

        );
        if($result){
        echo "<script>alert('You can now login');windown.href='login.php';</script>";


        }
      }
    
    

}

    ?>

<?php require "header.php" ?>
    <div class="card">
        <div class="card-body">
            <h1>Create User Control</h1>
            <form enctype="multipart/form-data" action="" method="post" >
                <div class="form-group">
                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>">
                <p style="color:red"><?php echo empty($nameError) ? '': "***".$nameError ?></p>
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="form-group">
                <p style="color:red"><?php echo empty($emailError) ? '': "***".$emailError ?></p>
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="form-group">
                <p style="color:red"><?php echo empty($passError) ? '': "***".$passError ?></p>
                    <label for="password">Password</label>
                    <input type="text" class="form-control" name="password">
                </div>
                
                    <label for="role">Admin</label>
                    <input type="checkbox" class="form-control" name="role">
                <br>
                
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    <a href="userlist.php" type="button" class="btn btn-warning">Back</a>
                </div>
            </form>
        </div>
    </div>


    <?php require "footer.html" ?>

