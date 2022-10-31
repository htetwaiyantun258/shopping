<?php
	session_start();
	require "config/config.php";
	require "config/common.php";
	if($_POST){


		if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['address']) || strlen($_POST['password']) < 4 ||  empty($_POST['password']) || empty($_POST['phone']) ){
			if (empty($_POST['name'])) {
				$nameError = "Fill the name!";
			}
			echo $_POST['password'];
			if (empty($_POST['email'])) {
				$emailError = "Fill the Email!";
			}
			if (empty($_POST['password'])) {
				$passError = "Fill the Password!";
			}
			if(strlen($_POST['password']) < 4){
				$passError = "Should Be 4 character at lease";
			}
			if (empty($_POST['address'])) {
				$addressError = "Fill the Address!";
			}
			if (empty($_POST['phone'])) {
				$phoneError = "Fill the phone!";
			}
		}else{

			$name = $_POST['name'];
			$password = password_hash($_POST['password'],PASSWORD_DEFAULT);
			
			$email = $_POST['email'];
			$address = $_POST['address'];
			$phone = $_POST['phone'];

			echo $address . $phone;

			$stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
			$email_result = $stmt->execute([":email" => $email]);
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			print_r($user);
			if($user){
				echo "<script>alert('Email is already');</script>";
			}else{
                 $stmt = $pdo->prepare("INSERT INTO users (name,email,password,address,phone) VALUES(:name,:email,:password,:address,:phone)");
				 $result = $stmt->execute(
					array(
						":name"=>$name,
						":email"=>$email,
						":password"=>$password,
						":address"=>$address,
						":phone"=>$phone,
						)
					);
                if ($result) {
                    echo "<script>alert('Register Success login');window.location.href='login.php';</script>";
                }
            }

		}

	}
?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="CodePixar">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>My Shop | Register</title>

	<!--
		CSS
		============================================= -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
</head>

<body>

	<!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index.html"><h4>AP Shopping<h4></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
				</div>
			</nav>
		</div>
		<div class="search_input" id="search_input_box">
			<div class="container">
				<form class="d-flex justify-content-between">
					<input type="text" class="form-control" id="search_input" placeholder="Search Here">
					<button type="submit" class="btn"></button>
					<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
				</form>
			</div>
		</div>
	</header>
	<!-- End Header Area -->

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Login/Register</h1>
					<nav class="d-flex align-items-center">
						<a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="category.html">Login/Register</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Login Box Area =================-->
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="login_form_inner">
						<h3>Register in to enter</h3>
						<form class="row login_form" action="register.php" method="post" >
							<div class="col-md-12 form-group">
								<input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>">
								<input type="text" class="form-control"  name="name" placeholder="name"
								style="<?php echo empty($nameError)? '':'border: 1px solid red;'; ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'name'">
							</div>
                            <div class="col-md-12 form-group">
								<input type="text" class="form-control"  name="email" placeholder="Email"
								style="<?php echo empty($emailError)? '':'border: 1px solid red;'; ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
							</div><div class="col-md-12 form-group">
								<input type="text" class="form-control"  name="phone" placeholder="Phone"
								style="<?php echo empty($phoneError)? '':'border: 1px solid red;'; ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone'">
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control"  name="address" placeholder="Address"
								style="<?php echo empty($addressError)? '':'border: 1px solid red;'; ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Address'">
							</div>
                            <div class="col-md-12 form-group">
								<input type="password" class="form-control"  name="password" placeholder="Password"
								style="<?php echo empty($passError)? '':'border: 1px solid red;'; ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							</div>
							<div class="col-md-12 form-group">
							<button type="submit" value="submit" class="primary-btn">register</button>
							</div>
							<div class="col-md-12 form-group">
								<a href="login.php"   class="btn primary-btn">Log In</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->

	<!-- start footer Area -->
	<?php include("footer.php"); ?>
	<!-- End footer Area -->


	<script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery.sticky.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<!--gmaps Js-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="js/gmaps.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>