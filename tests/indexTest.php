<?php

use PHPUnit\Framework\TestCase;

class indexTest extends TestCase
{
    protected function setUp(): void
    {
        // Initialize session for testing
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Set up a mock cart session for testing
        $_SESSION['cart'] = [
            'apple' => ['price' => 1.00, 'quantity' => 2],
            'banana' => ['price' => 0.50, 'quantity' => 3],
        ];
    }

    public function testCartSessionIsSet()
    {
        $this->assertArrayHasKey('cart', $_SESSION, "Cart session should be set.");
        $this->assertNotEmpty($_SESSION['cart'], "Cart session should not be empty.");
    }

    public function testTotalCartQuantityAndPrice()
    {
        $totalQuantity = 0;
        $totalPrice = 0;
        foreach ($_SESSION['cart'] as $item => $details) {
            $totalQuantity += $details['quantity'];
            $totalPrice += $details['price'] * $details['quantity'];
        }

        $this->assertEquals(5, $totalQuantity, "Total cart quantity should be 5.");
        $this->assertEquals(3.50, $totalPrice, "Total cart price should be 3.50.");
    }

    public function testHtmlElementsExist()
    {
        $html = file_get_contents('index.php');
        
        $this->assertStringContainsString('<title>Grocery Store</title>', $html, "Page title should be present.");
        $this->assertStringContainsString('<h1 class="display-4 font-weight-bold text-white">Enjoy a Healthy Life by Getting Fresh Grocery</h1>', $html, "Hero section heading should be present.");
        $this->assertStringContainsString('<footer class="bg-dark text-white py-4">', $html, "Footer should be present.");
    } 

    protected function tearDown(): void
    {
        // Clear session after testing
        $_SESSION['cart'] = [];
    }
}
