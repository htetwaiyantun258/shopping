<?php

  session_start();
  require 'config/config.php';
  require "config/common.php";

  // if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  //   header('Location: login.php');
  // }
  // if($_SESSION['role'] != 1){
  //   header('Location: login.php');
  // }
  // if(isset($_POST['search'])){
  //   setcookie('search', $_POST['search'], time() + (86400 * 30), "/"); // 86400 = 1 day
  // }else{
  //   if(empty($_GET['pageno'])){
  //     unset($_COOKIE['search']); 
  //     setcookie('search', null, -1, '/'); 
  //   }
  // }

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
                <h3 class="card-title">user Listings</h3>
              </div>

             

              <!-- /.card-header -->
              <div class="card-body">
                <div>
                  <a href="add.php" class="btn btn-success">New Blog Posts</a>
                </div>
                <br>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Content</th>
                      <th style="width: 150px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                     
                  </tbody>
                </table>
                      <br>
                <nav> 

                
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
