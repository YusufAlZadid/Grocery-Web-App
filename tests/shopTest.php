<?php

use PHPUnit\Framework\TestCase;

class ShopTest extends TestCase
{
    private $products;

    protected function setUp(): void
    {
        // Initialize the products array
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

    public function testProductPrice()
    {
        $productName = 'Apple';
        $expectedPrice = 1.00;

        $this->assertArrayHasKey($productName, $this->products);

        $this->assertEquals($expectedPrice, $this->products[$productName]['price']);
    }

    public function testSearchProductFound()
    {
        $searchQuery = 'apple';

        $filteredProducts = $this->filterProducts($searchQuery);

        $this->assertArrayHasKey('Apple', $filteredProducts);
    }

    public function testEmptySearchQueryReturnsAllProducts()
    {
        $searchQuery = '';

        $filteredProducts = $this->filterProducts($searchQuery);

        $this->assertCount(count($this->products), $filteredProducts);
    }

    // Helper function to simulate product filtering logic
    private function filterProducts($searchQuery)
    {
        $filteredProducts = [];
        if ($searchQuery) {
            foreach ($this->products as $productName => $details) {
                if (strpos(strtolower($productName), strtolower($searchQuery)) !== false) {
                    $filteredProducts[$productName] = $details;
                }
            }
        } else {
            $filteredProducts = $this->products;
        }
        return $filteredProducts;
    }

    protected function tearDown(): void
    {
        // Clear session after testing
        $_SESSION['cart'] = [];
    }
}
