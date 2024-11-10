<?php
session_start();

$products = [
    "Apple" => ["price" => 1.00, "image" => "Images/apple.jpg", "category" => "fruits"],
    "Banana" => ["price" => 0.50, "image" => "Images/banana.jpg", "category" => "fruits"],
    "Orange" => ["price" => 0.75, "image" => "Images/orange.jpg", "category" => "fruits"],
    "Carrot" => ["price" => 1.20, "image" => "Images/carrot.jpg", "category" => "vegetables"],
    "Broccoli" => ["price" => 1.80, "image" => "Images/broccoli.jpg", "category" => "vegetables"],
    "Milk" => ["price" => 1.50, "image" => "Images/milk.jpg", "category" => "dairy"],
    "Cheese" => ["price" => 2.50, "image" => "Images/cheese.jpg", "category" => "dairy"],
    "Chips" => ["price" => 2.00, "image" => "Images/chips.jpg", "category" => "snacks"],
    "Cookies" => ["price" => 2.50, "image" => "Images/cookies.jpg", "category" => "snacks"],
    // Add more products as needed
];

$searchQuery = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';

$filteredProducts = [];

if ($searchQuery) {
    foreach ($products as $productName => $details) {
        if (strpos(strtolower($productName), $searchQuery) !== false) {
            $filteredProducts[$productName] = $details;
        }
    }
} else {
    $filteredProducts = $products;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Shop - Grocery Store</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
	<link rel="stylesheet" href="styles.css" />
</head>
<body>

	<!-- Header Section -->
	<header class="bg-light py-3">
		<div class="container">
			<nav class="navbar navbar-expand-lg navbar-light">
				<a class="navbar-brand" href="#">Grocery Store</a>
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

	<!-- Shop Section -->
	<section class="shop py-5">
		<div class="container">
			<h1 class="mb-4">Shop All Products</h1>
			<div class="row">
				<?php if (empty($filteredProducts)): ?>
				<div class="col-12">
					<p class="alert alert-warning">No products found.</p>
				</div>
				<?php else: ?>
				<?php foreach ($filteredProducts as $productName => $details): ?>
				<div class="col-md-4">
					<div class="card mb-4 shadow-sm">
						<img src="<?php echo $details['image']; ?>" class="card-img-top" alt="<?php echo $productName; ?>" />
						<div class="card-body">
							<h5 class="card-title">
								<?php echo $productName; ?>
							</h5>
							<p class="card-text">
								$<?php echo number_format($details['price'], 2); ?>
							</p>
							<a href="product.php?name=<?php echo $productName; ?>" class="btn btn-primary">View Product</a>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

