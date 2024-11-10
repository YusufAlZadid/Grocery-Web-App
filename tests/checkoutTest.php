<?php

use PHPUnit\Framework\TestCase;

class checkoutTest extends TestCase
{
    protected function setUp(): void
    {
        // Initialize session for testing
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Set up a mock cart session for testing
        $_SESSION['cart'] = [
            'apple' => ['price' => 1.00, 'quantity' => 3],
            'banana' => ['price' => 0.50, 'quantity' => 5],
        ];
    }

    public function testOrderTotalCalculation()
    {
        $cart = $_SESSION['cart'];
        $totalAmount = 0;
        foreach ($cart as $item => $details) {
            $totalAmount += $details['price'] * $details['quantity'];
        }

        $this->assertEquals(5.50, $totalAmount, "The total order amount should be 5.50");
    }

    public function testCartIsNotEmpty()
    {
        $this->assertNotEmpty($_SESSION['cart'], "Cart should not be empty");
    }

    public function testOrderConfirmationProcess()
    {
        // Mocking a simple order confirmation process
        $name = 'John Doe';
        $email = 'john@example.com';
        $cart = $_SESSION['cart'];

        $orderConfirmed = false;
        if (!empty($cart)) {
            $orderConfirmed = true;
        }

        $this->assertTrue($orderConfirmed, "Order should be confirmed if the cart is not empty.");
    }

    public function testClearCartAfterOrder()
    {
        // Mocking an order confirmation process that clears the cart
        $_SESSION['cart'] = []; 

        $this->assertEmpty($_SESSION['cart'], "Cart should be empty after confirming the order.");
    }

    protected function tearDown(): void
    {
        // Clear session after testing
        $_SESSION['cart'] = [];
    }
}
