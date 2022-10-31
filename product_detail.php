<?php include('header.php');

$stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
$stmt->execute();
$Presult = $stmt->fetch(PDO::FETCH_ASSOC);


?>
<!--================Single Product Area =================-->
<div class="product_image_area" style="padding-top:0 !important;">
  <div class="container">
    <div class="row s_product_inner">
    
      <div class="col-lg-6">
        <div>
          <img src="admin/images/<?php echo $Presult['image'] ?>" alt="" style="width:450px">
        </div>
      </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text">
          <h3><?php echo $Presult['name'] ?></h3>
          <h2><?php echo $Presult['price'] ?></h2>
          <ul class="list">
            <li><a class="active" href="#"><span>Category</span> : Household</a></li>
            <li><a href="#"><span>Availibility</span> : <?php echo $Presult['quantity'] ?></a></li>
          </ul>
          <p><?php echo $Presult['description'] ?></p>
          <form action="addtocart.php" method="post">
              <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>">
              <input type="hidden" name="id" value="<?php echo $Presult['id'] ?>">
            <div class="product_count">
              <label for="qty">Quantity:</label>
              <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
              <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
              class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
              <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) ( sst > 0 ); result.value--;return false;"
              class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
            </div>
          
          <div class="card_area d-flex align-items-center">
            <button class="primary-btn" type="submit" value="submit"  style="border:1px solid">Add to Cart</button>
            <a class="primary-btn" href="index.php">Back</a>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div><br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
