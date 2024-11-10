<?php
session_start();

// Handle item removal
if (isset($_POST['remove_item'])) {
    $itemToRemove = $_POST['remove_item'];
    unset($_SESSION['cart'][$itemToRemove]);
    header("Location: cart.php");
    exit();
}

// Handle quantity update
if (isset($_POST['update_quantity'])) {
    $itemToUpdate = $_POST['item_name'];
    $newQuantity = intval($_POST['quantity']);
    if ($newQuantity > 0) {
        $_SESSION['cart'][$itemToUpdate]['quantity'] = $newQuantity;
    } else {
        unset($_SESSION['cart'][$itemToUpdate]); // Remove item if quantity is set to 0
    }
    header("Location: cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Shopping Cart - Grocery Store</title>
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

	<!-- Shopping Cart Section -->
	<section class="shopping-cart py-5">
		<div class="container">
			<h1 class="mt-4">Your Shopping Cart</h1>
			<?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
			<ul class="list-group mb-4">
				<?php
					  $total = 0;
					  foreach ($_SESSION['cart'] as $item => $details):
						  $itemTotal = $details['price'] * $details['quantity'];
						  $total += $itemTotal;
				?>
				<li class="list-group-item d-flex justify-content-between align-items-center">
					<div>
						<form method="post" class="d-inline-block mr-3">
							<input type="hidden" name="item_name" value="<?php echo $item; ?>" />
							<input type="number" name="quantity" value="<?php echo $details['quantity']; ?>" min="1" class="form-control d-inline-block" style="width: 80px;" />
							<button type="submit" name="update_quantity" class="btn btn-secondary btn-sm ml-2">Update</button>
						</form>
						<?php echo htmlspecialchars($item); ?>
					</div>
					<div>
						<span class="badge badge-primary badge-pill">
							$<?php echo number_format($itemTotal, 2); ?>
						</span>
						<form method="post" class="d-inline-block ml-3">
							<input type="hidden" name="remove_item" value="<?php echo $item; ?>" />
							<button type="submit" class="btn btn-danger btn-sm">Remove</button>
						</form>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
			<h3>
				Total: $<?php echo number_format($total, 2); ?>
			</h3>
			<a href="index.php" class="btn btn-primary">Continue Shopping</a>
			<a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
			<?php else: ?>
			<p class="alert alert-info">Your cart is empty.</p>
			<a href="index.php" class="btn btn-primary">Start Shopping</a>
			<?php endif; ?>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
