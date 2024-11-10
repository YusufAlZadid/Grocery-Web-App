<?php

use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    protected function setUp(): void
    {
        // Initialize session for testing
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['categories'] = [];
    }

    public function testAddCategory()
    {
        $_SESSION['categories']['fruits'] = ['name' => 'Fruits'];
        $this->assertArrayHasKey('fruits', $_SESSION['categories']);
        $this->assertEquals('Fruits', $_SESSION['categories']['fruits']['name']);
    }

    public function testRemoveCategory()
    {
        $_SESSION['categories']['fruits'] = ['name' => 'Fruits'];
        unset($_SESSION['categories']['fruits']);
        $this->assertArrayNotHasKey('fruits', $_SESSION['categories']);
    }

    public function testUpdateCategoryName()
    {
        $_SESSION['categories']['fruits'] = ['name' => 'Fruits'];
        $_SESSION['categories']['fruits']['name'] = 'Fresh Fruits';
        $this->assertEquals('Fresh Fruits', $_SESSION['categories']['fruits']['name']);
    }

    protected function tearDown(): void
    {
        // Clear session after testing
        $_SESSION['categories'] = [];
    }
}
