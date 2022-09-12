<?php
session_start();
require "../config/config.php";

if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
  header('Location: login.php');
}

if($_SESSION['role'] != 1){
  header('Location: login.php');
}
if(isset($_POST['search'])){
  setcookie('search', $_POST['search'], time() + (86400 * 30), "/"); // 86400 = 1 day
}else{
  if(empty($_GET['pageno'])){
    unset($_COOKIE['search']); 
    setcookie('search', null, -1, '/'); 
  }
}

?>

<?php include("header.php") ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php 

                if(!empty($_GET["pageno"])){
                  $pageno = $_GET["pageno"];
                }else{ 
                  $pageno = 1;
                }
                $numOfRec = 5;
                $offset = ($pageno - 1) * $numOfRec;

               if(empty($_POST['search']) && empty($_COOKIE['search'])){
                $stmt = $pdo->prepare("SELECT * FROM users ORDER BY id DESC");
                $stmt->execute();
                $rawResult = $stmt->fetchAll();
                $total_pages = ceil(count($rawResult) / $numOfRec);
                
                $stmt = $pdo->prepare("SELECT * FROM users ORDER BY id DESC limit $offset,$numOfRec");
                $stmt->execute();
                $result = $stmt->fetchAll();

               }else{ 
                $searchKey = isset($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
                $stmt = $pdo->prepare("SELECT * FROM users WHERE name LIKE '%$searchKey%' ORDER BY id DESC");
                $stmt->execute();
                $rawResult = $stmt->fetchAll();
                $total_pages = ceil(count($rawResult) / $numOfRec);
                
                $stmt = $pdo->prepare("SELECT * FROM users WHERE name LIKE '%$searchKey%' ORDER BY id DESC limit $offset,$numOfRec");
                $stmt->execute();
                $result = $stmt->fetchAll();
               }
                 ?>
                <div>
                  <a href="user-create.php" type="button" class="btn btn-primary ">Create User</a>
                </div><br>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>User Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        if($result){
                          $i = 1;
                          foreach($result as $value){
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $value['name'] ?></td>
                        <td><?php echo $value['email'] ?></td>  
                        <td><?php  echo $value['role'] == 1 ? 'admin': 'user' ?></td>       

                        <td>
                        <div class="btn-group">
                        <div class="container">
                        <a href="user-edit.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-warning">Edit</a>
                        </div>
                        <div class="container">
                        <a href="user-delete.php?id=<?php echo $value['id'] ?>" onclick="return confirm('Are you sure you want to delete')" type="button" class="btn btn-danger">Delete</a>
                        </div>
                        </div>
                      </td>
                    </tr>

                    <?php
                    $i++;
                          }
                        }
                    ?>
                  </tbody>
                </table><br>
                <nav aria-label="Page navigation example" style="float:right">
                    <ul class="pagination">
                      <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                      <li class="page-item <?php if($pageno <= 1 ){ echo ' disabled'; }?>">
                        <a class="page-link" href="<?php if($pageno <=1){ echo '#';}else{ echo '?pageno=' .($pageno-1); } ?>">Previous</a>
                    </li>
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#';}else{ echo '?pageno=' .($pageno+1); } ?>">Next</a></li>
                      <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages ?>">Last</a></li>
                    </ul>
</nav>
              </div>
              <!-- /.card-body -->  
            </div>
            <!-- /.card -->
          </div>
        <!-- I am row here --> 
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   
  <?php include("footer.html") ?>
