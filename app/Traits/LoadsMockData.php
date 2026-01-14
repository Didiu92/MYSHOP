<?php

namespace App\Traits;

trait LoadsMockData
{
    /**
     * Load categories from mock file
     */
    protected function getCategories(): array
    {
        return require database_path('data/mock-categories.php');
    }

    /**
     * Load offers from mock file
     */
    protected function getOffers(): array
    {
        return require database_path('data/mock-offers.php');
    }

    /**
     * Load products from mock file
     */
    protected function getProducts(): array
    {
        return require database_path('data/mock-products.php');
    }

    /**
     * Load cart items from mock file
     */
    protected function getCart(): array
    {
        return require database_path('data/mock-cart.php');
    }
}