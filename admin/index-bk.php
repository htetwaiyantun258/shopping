<?php
session_start();
require "../config/config.php";

if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
  header('Location: login.php');
}

?>

<?php include("header.html") ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php 

                if($_GET["pageno"]){
                  $pageno = $_GET["pageno"];
                }else{ 
                  $pageno = 1;
                }
                $numOfRec = 1;
                $offset = ($pageno - 1) * $numOfRec;

               if(empty($_POST['search'])){
                $stmt = $pdo->prepare("SELECT * FROM post ORDER BY id DESC");
                $stmt->execute();
                $rawResult = $stmt->fetchAll();
                $total_pages = ceil(count($rawResult) / $numOfRec);
                
                $stmt = $pdo->prepare("SELECT * FROM post ORDER BY id DESC limit $offset,$numOfRec");
                $stmt->execute();
                $result = $stmt->fetchAll();

               }else{ 
                $searchKey = $POST['search'];
                $stmt = $pdo->prepare("SELECT * FROM post WHERE title LIKE %$searchKey% ORDER BY id DESC");
                $stmt->execute();
                $rawResult = $stmt->fetchAll();
                $total_pages = ceil(count($rawResult) / $numOfRec);
                
                $stmt = $pdo->prepare("SELECT * FROM post WHERE title LIKE %$searchKey% ORDER BY id DESC limit $offset,$numOfRec");
                $stmt->execute();
                $result = $stmt->fetchAll();
               }
                 ?>
                <div>
                  <a href="add.php" type="button" class="btn btn-primary ">Create New</a>
                </div><br>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Content</th>
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
                        <td><?php echo $value['title'] ?></td>
                        <td><?php echo substr($value['description'],0,80); ?></td>       
                        <td>
                        <div class="btn-group">
                        <div class="container">
                        <a href="edit.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-warning">Edit</a>
                        </div>
                        <div class="container">
                        <a href="delete.php?id=<?php echo $value['id'] ?>" onclick="return confirm('Are you sure you want to delete')" type="button" class="btn btn-danger">Delete</a>
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
