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
                        <h3 class="card-title">Order Details</h3>
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

                // $stmt = $pdo->prepare("SELECT * FROM sale_order WHERE id=".$_GET['id']);
                // $stmt->execute();
                // $sale_order_result= $stmt->fetchAll();

                $stmt = $pdo->prepare("SELECT * FROM sale_order_details WHERE sale_order_id =". $_GET['id']);
                $stmt->execute();
                $rawResult = $stmt->fetchAll();
                $total_pages = ceil(count($rawResult) / $numOfRec);

                $stmt = $pdo->prepare("SELECT * FROM sale_order_details WHERE sale_order_id =". $_GET['id']);
                $stmt->execute();
                $result = $stmt->fetchAll();
        
            ?>
                        <div>
                            <a href="order_list.php" class="btn btn-success">Back</a>
                        </div>
                        <br>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Order Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($result){
                                $i = 1;
                                foreach($result as $value){
                            ?>
                                <?php 
                                $p_stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$value['product_id']);
                                $p_stmt->execute();
                                $p_result = $p_stmt->fetchAll();
                            ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $p_result[0]['name'] ?></td>
                                    <td><?php echo $value['quantity']; ?></td>
                                    <td><?php echo date('Y-m-d',strtotime($value['order_date'])); ?></td>
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
                                    <a class="page-link"
                                        href="<?php if($pageno <=1){ echo '#';}else{ echo '?pageno=' .($pageno-1); } ?>">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled';} ?>">
                                    <a class="page-link"
                                        href="<?php if($pageno >= $total_pages){ echo '#';}else{ echo '?pageno=' .($pageno+1); } ?>">Next</a>
                                </li>
                                <li class="page-item"><a class="page-link"
                                        href="?pageno=<?php echo $total_pages ?>">Last</a></li>
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