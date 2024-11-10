<?php

use PHPUnit\Framework\TestCase;

class productTest extends TestCase
{
    protected $products;

    protected function setUp(): void
    {
        // Define the products array as in the original script
        $this->products = [
            "Apple" => ["price" => 1.00, "image" => "Images/apple.jpg", "category" => "fruits"],
            "Banana" => ["price" => 0.50, "image" => "Images/banana.jpg", "category" => "fruits"],
            "Orange" => ["price" => 0.75, "image" => "Images/orange.jpg", "category" => "fruits"],
            "Carrot" => ["price" => 1.20, "image" => "Images/carrot.jpg", "category" => "vegetables"],
            "Broccoli" => ["price" => 1.80, "image" => "Images/broccoli.jpg", "category" => "vegetables"],
            "Milk" => ["price" => 1.50, "image" => "Images/milk.jpg", "category" => "dairy"],
            "Cheese" => ["price" => 2.50, "image" => "Images/cheese.jpg", "category" => "dairy"],
            "Chips" => ["price" => 2.00, "image" => "Images/chips.jpg", "category" => "snacks"],
            "Cookies" => ["price" => 2.50, "image" => "Images/cookies.jpg", "category" => "snacks"]
        ];

        // Initialize session for testing
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function testAddProductToCart()
    {
        $productName = "Apple";
        $quantity = 2;

        if (!isset($_SESSION['cart'][$productName])) {
            $_SESSION['cart'][$productName] = [
                'price' => $this->products[$productName]['price'],
                'quantity' => $quantity
            ];
        } else {
            $_SESSION['cart'][$productName]['quantity'] += $quantity;
        }

        $this->assertArrayHasKey($productName, $_SESSION['cart']);
        $this->assertEquals(2, $_SESSION['cart'][$productName]['quantity']);
        $this->assertEquals(1.00, $_SESSION['cart'][$productName]['price']);
    }

    public function testUpdateProductQuantityInCart()
    {
        $productName = "Banana";
        $quantity = 1;

        $_SESSION['cart'][$productName] = [
            'price' => $this->products[$productName]['price'],
            'quantity' => $quantity
        ];

        $additionalQuantity = 2;
        $_SESSION['cart'][$productName]['quantity'] += $additionalQuantity;

        $this->assertEquals(3, $_SESSION['cart'][$productName]['quantity']);
    }

    public function testCartIsEmptyInitially()
    {
        $this->assertEmpty($_SESSION['cart']);
    }

    public function testCartTotalItemsAndPrice()
    {
        $_SESSION['cart']["Apple"] = ['price' => 1.00, 'quantity' => 2];
        $_SESSION['cart']["Banana"] = ['price' => 0.50, 'quantity' => 4];

        $totalQuantity = 0;
        $totalPrice = 0.0;
        foreach ($_SESSION['cart'] as $item => $details) {
            $totalQuantity += $details['quantity'];
            $totalPrice += $details['price'] * $details['quantity'];
        }

        $this->assertEquals(6, $totalQuantity);
        $this->assertEquals(4.00, $totalPrice);
    }

    protected function tearDown(): void
    {
        // Clear session after testing
        $_SESSION['cart'] = [];
    }
}

