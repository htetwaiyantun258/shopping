<?php 
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}
		include('header.php');
		if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
			header('Location: login.php');
		  }

		


		if(!empty($_GET["pageno"])){
			$pageno = $_GET["pageno"];
		}else{ 
			$pageno = 1;
		}
		$numOfRec = 5;
		$offset = ($pageno - 1) * $numOfRec;

		if(empty($_POST['search']) && empty($_COOKIE['search'])){
			if(!empty($_GET['category_id'])){
				$catId = $_GET['category_id'];
				$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=$catId AND quantity > 0 ORDER BY id DESC");
				$stmt->execute();
				$rawResult = $stmt->fetchAll();
				$total_pages = ceil(count($rawResult) / $numOfRec);
				
				$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=$catId AND quantity > 0 ORDER BY id DESC limit $offset,$numOfRec");
				$stmt->execute();
				$result = $stmt->fetchAll();

			}else{
				$stmt = $pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC");
				$stmt->execute();
				$rawResult = $stmt->fetchAll();
				$total_pages = ceil(count($rawResult) / $numOfRec);
				
				$stmt = $pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC limit $offset,$numOfRec");
				$stmt->execute();
				$result = $stmt->fetchAll();
				

			}

		}else{ 
		$searchKey = isset($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
		$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity > 0 ORDER BY id DESC");
		$stmt->execute();
		$rawResult = $stmt->fetchAll();
		$total_pages = ceil(count($rawResult) / $numOfRec);
		
		$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity > 0 ORDER BY id DESC limit $offset,$numOfRec");
		$stmt->execute();
		$result = $stmt->fetchAll();
		}
   

?> <div class="container">
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-5">
            <div class="sidebar-categories">
                <div class="head">Browse Categories</div>
                <ul class="main-categories">
                    <li class="main-nav-list">
                        <?php 
					$cate_stmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
					$cate_stmt->execute();
					$cat_result = $cate_stmt->fetchAll();
					?>
                        <?php 
					foreach($cat_result as $value):?>

                        <a href="index.php?category_id=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a>
                        <?php 
					endforeach; ?>
                    </li>

                </ul>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-7">
            <!-- start Filter Bar -->
            <div class="filter-bar d-flex flex-wrap align-items-center">
                <div class="pagination">
                    <a href="?pageno=1" class="active">First</a>
                    <a <?php if($pageno <= 1 ){ echo ' disabled'; }?>
                        href="<?php if($pageno <=1){ echo '#';}else{ echo '?pageno=' .($pageno-1); } ?>"
                        class="prev-arrow">
                        <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="active"><?php echo $pageno; ?></a>
                    <a href="<?php if($pageno >= $total_pages){ echo '#';}else{ echo '?pageno=' .($pageno+1); } ?>"
                        class="next-arrow">
                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                    </a>
                    <a <?php if($pageno >= $total_pages){ echo 'disabled';} ?> href="?pageno=<?php echo $total_pages ?>"
                        class="active">Last
                    </a>
                </div>
            </div>
            <!-- End Filter Bar -->
            <!-- Start Best Seller -->
            <section class="lattest-product-area pb-40 category-list">
                <div class="row">
                    <!-- single product -->
                    <?php
						foreach($result as $value):?>

                    <div class="col-lg-4 col-md-6">
                        <div class="single-product">
                            <img class="img-fluid" src="admin/images/<?php echo $value['image'] ?>" alt=""
                                style="width:254px; height:254px;">
                            <div class="product-details">
                                <h6><?php echo $value['name'] ?></h6>
                                <div class="price">
                                    <h6><?php echo $value['price'] ?></h6>
                                    <!-- <h6 class="l-through">$210.00</h6> -->
                                </div>
                                <div class="prd-bottom">
                                    <form action="addtocart.php" method="post">
                                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>">
                                        <input type="hidden" name="id" value="<?php echo $value['id'] ?>">
                                        <input type="hidden" name="qty" value="1">

                                        <div class="social-info">
                                            <button style="display: contents;" class="social-info" type="submit">
                                                <span class="ti-bag"></span>
                                                <p style="left:18px" class="hover-text"> add to bag</p>
                                            </button>
                                        </div>
                                        <a href="product_detail.php?id=<?php echo $value['id'] ?>" class="social-info">
                                            <span class="lnr lnr-move"></span>
                                            <p class="hover-text">view more</p>
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <!-- single product -->

                </div>
            </section>
            <!-- End Best Seller -->
            <?php include('footer.php');?>