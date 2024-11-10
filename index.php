<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Grocery Store</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
	<link rel="stylesheet" href="styles.css" />
	<style>
        /* Hover Effect for Categories */
        .category-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

            .category-card:hover {
                transform: scale(1.05);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            }

        /* Fade-in Animation */
        .category-section {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Bounce Effect on Hover */
        .btn-primary {
            transition: transform 0.3s ease;
        }

            .btn-primary:hover {
                transform: translateY(-2px);
            }

        .btn-success:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

	<!-- Header Section -->
	<header class="bg-white shadow-sm py-3">
		<div class="container">
			<nav class="navbar navbar-expand-lg navbar-light">
				<a class="navbar-brand font-weight-bold text-primary" href="#">Grocery Store</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<a class="nav-link" href="index.php">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="shop.php">Shop</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Categories</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Contact</a>
						</li>
						<!-- Cart Button with Badge -->
						<li class="nav-item position-relative">
							<a class="nav-link btn btn-outline-primary text-primary" href="cart.php">
								<i class="fas fa-shopping-cart"></i> Cart
								<?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0):
										  $totalQuantity = 0;
										  $totalPrice = 0;
										  foreach ($_SESSION['cart'] as $item => $details) {
											  $totalQuantity += $details['quantity'];
											  $totalPrice += $details['price'] * $details['quantity'];
										  }
                                ?>
								<span class="badge badge-pill badge-danger cart-badge">
									<?php echo $totalQuantity; ?> items | $<?php echo number_format($totalPrice, 2); ?>
								</span>
								<?php endif; ?>
							</a>
						</li>
					</ul>
					<form class="form-inline my-2 my-lg-0" method="get" action="shop.php">
						<input class="form-control mr-sm-2" type="search" placeholder="Search products" aria-label="Search" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
						<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
					</form>
				</div>
			</nav>
		</div>
	</header>

	<!-- Hero Section -->
	<section class="hero bg-light text-center py-5" style="background-image: url('Images/grocery-bg.jpg'); background-size: cover; background-position: center;">
		<!-- Black Overlay -->
		<div class="overlay"></div>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<h1 class="display-4 font-weight-bold text-white">Enjoy a Healthy Life by Getting Fresh Grocery</h1>
					<p class="lead text-white">Fresh vegetables, fruits, dairy, and more directly to your doorstep. Start your healthy journey with us today!</p>
					<a href="shop.php" class="btn btn-success btn-lg mt-3">Start Shopping</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Popular Categories Section -->
	<section class="category-section py-5">
		<div class="container">
			<h2 class="text-center text-primary font-weight-bold mb-5">Our Popular Categories</h2>
			<div class="row">
				<div class="col-md-3 mb-4">
					<a href="category.php?category=vegetables" class="text-decoration-none">
						<div class="card category-card border-0 shadow-sm">
							<img src="Images/vegetables.jpg" class="card-img-top" alt="Fresh Vegetables" />
							<div class="card-body text-center">
								<h5 class="card-title text-primary font-weight-bold">Fresh Vegetables</h5>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-3 mb-4">
					<a href="category.php?category=fruits" class="text-decoration-none">
						<div class="card category-card border-0 shadow-sm">
							<img src="Images/fruits.jpg" class="card-img-top" alt="Fresh Fruits" />
							<div class="card-body text-center">
								<h5 class="card-title text-primary font-weight-bold">Fresh Fruits</h5>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-3 mb-4">
					<a href="category.php?category=dairy" class="text-decoration-none">
						<div class="card category-card border-0 shadow-sm">
							<img src="Images/dairy.jpg" class="card-img-top" alt="Dairy Products" />
							<div class="card-body text-center">
								<h5 class="card-title text-primary font-weight-bold">Dairy Products</h5>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-3 mb-4">
					<a href="category.php?category=snacks" class="text-decoration-none">
						<div class="card category-card border-0 shadow-sm">
							<img src="Images/snacks.jpg" class="card-img-top" alt="Snacks" />
							<div class="card-body text-center">
								<h5 class="card-title text-primary font-weight-bold">Snacks</h5>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Footer Section -->
	<footer class="bg-dark text-white py-4">
		<div class="container text-center">
			<p class="mb-0">&copy; 2024 Al Zadid Yusuf. All rights reserved.</p>
		</div>
	</footer>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
