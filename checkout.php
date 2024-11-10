<?php
session_start();
require 'db_config.php'; // Include the database configuration file with RDS connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
    // Collect user information from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $cart = $_SESSION['cart'];

    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Calculate the total order amount
        $totalAmount = 0;
        foreach ($cart as $details) {
            $totalAmount += $details['price'] * $details['quantity'];
        }

        // Insert a new order record into the orders table
        $stmt = $pdo->prepare("INSERT INTO orders (user_name, user_email, total_amount, order_date) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $totalAmount]);

        // Retrieve the order ID
        $orderId = $pdo->lastInsertId();

        // Insert each cart item into the order_items table
        foreach ($cart as $item => $details) {
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->execute([$orderId, $item, $details['quantity'], $details['price']]);
        }

        // Commit the transaction
        $pdo->commit();

        // Clear the cart and set order confirmation message
        $_SESSION['cart'] = [];
        $orderConfirmed = true;

    } catch (PDOException $e) {
        // Roll back the transaction if something goes wrong
        $pdo->rollBack();
        echo "Error processing your order: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Checkout - Grocery Store</title>
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

	<!-- Checkout Section -->
	<section class="checkout py-5">
		<div class="container">
			<h1 class="mt-4">Checkout</h1>

			<?php if (isset($orderConfirmed) && $orderConfirmed): ?>
			<div class="alert alert-success">
				Thank you for your order! Your order has been confirmed.
			</div>
			<a href="index.php" class="btn btn-primary">Continue Shopping</a>
			<?php elseif (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
			<ul class="list-group mb-4">
				<?php
					  $total = 0;
					  foreach ($_SESSION['cart'] as $item => $details):
						  $itemTotal = $details['price'] * $details['quantity'];
						  $total += $itemTotal;
                ?>
				<li class="list-group-item d-flex justify-content-between align-items-center">
					<?php echo $details['quantity']; ?> x <?php echo htmlspecialchars($item); ?>
					<span class="badge badge-primary badge-pill">
						$<?php echo number_format($itemTotal, 2); ?>
					</span>
				</li>
				<?php endforeach; ?>
			</ul>
			<h3>
				Total: $<?php echo number_format($total, 2); ?>
			</h3>

			<!-- User details form -->
			<form method="post">
				<div class="form-group">
					<label for="name">Your Name:</label>
					<input type="text" id="name" name="name" class="form-control" required />
				</div>
				<div class="form-group">
					<label for="email">Your Email:</label>
					<input type="email" id="email" name="email" class="form-control" required />
				</div>
				<button type="submit" name="confirm_order" class="btn btn-success">Confirm Order</button>
			</form>
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
