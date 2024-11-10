<?php

use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    protected function setUp(): void
    {
        // Initialize session for testing
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['cart'] = [];
    }

    public function testAddItemToCart()
    {
        $_SESSION['cart']['apple'] = ['price' => 1.00, 'quantity' => 1];
        $this->assertArrayHasKey('apple', $_SESSION['cart']);
        $this->assertEquals(1, $_SESSION['cart']['apple']['quantity']);
    }

    public function testRemoveItemFromCart()
    {
        $_SESSION['cart']['apple'] = ['price' => 1.00, 'quantity' => 1];
        unset($_SESSION['cart']['apple']);
        $this->assertArrayNotHasKey('apple', $_SESSION['cart']);
    }

    public function testUpdateItemQuantityInCart()
    {
        $_SESSION['cart']['apple'] = ['price' => 1.00, 'quantity' => 1];
        $_SESSION['cart']['apple']['quantity'] = 3;
        $this->assertEquals(3, $_SESSION['cart']['apple']['quantity']);
    }

    protected function tearDown(): void
    {
        // Clear session after testing
        $_SESSION['cart'] = [];
    }
}
