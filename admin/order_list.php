<?php

  session_start();
  require 'config/config.php';
  require "config/common.php";

  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('Location: login.php');
  }
  if($_SESSION['role'] != 1){
    header('Location: login.php');
  }
//   if(isset($_POST['search'])){
//     setcookie('search', $_POST['search'], time() + (86400 * 30), "/"); // 86400 = 1 day
//   }else{
//     if(empty($_GET['pageno'])){
//       unset($_COOKIE['search']); 
//       setcookie('search', null, -1, '/'); 
//     }
//   }

?>

<?php
  include 'header.php';
?>

  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
   

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Order Listing</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <?php 

                if(!empty($_GET["pageno"])){
                $pageno = $_GET["pageno"];
                }else{ 
                $pageno = 1;
                }
                $numOfRec = 4;
                $offset = ($pageno - 1) * $numOfRec;

                
                $stmt = $pdo->prepare("SELECT * FROM sale_order ORDER BY id DESC");
                $stmt->execute();
                $rawResult = $stmt->fetchAll();
                $total_pages = ceil(count($rawResult) / $numOfRec);

                $stmt = $pdo->prepare("SELECT * FROM sale_order ORDER BY id DESC limit $offset,$numOfRec");
                $stmt->execute();
                $result = $stmt->fetchAll();
                
            ?>
                <div>
                  <a href="cat_add.php" class="btn btn-success">New Category</a>
                </div>
                <br>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>User Name</th>
                      <th>Total Price</th>
                      <th>Order Date</th>
                      <th style="width: 150px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                                if($result){
                                $i = 1;
                                foreach($result as $value){
                            ?>
                            <?php 
                                $user_stmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['user_id']);
                                $user_stmt->execute();
                                $user_result = $user_stmt->fetchAll();
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $user_result[0]['name'] ?></td>
                                <td><?php echo $value['total_price']; ?></td>       
                                <td><?php echo date('Y-m-d',strtotime($value['order_date'])); ?></td>  

                                <td>
                                <div class="btn-group">
                                    <div class="container">
                                    <a href="order_details.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-primary">View</a>
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
                </table>
                      <br>
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
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

  <!-- /.content-wrapper -->

<?php include 'footer.html' ?>
