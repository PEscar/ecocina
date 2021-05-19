<?php

namespace App\Interfaces;

interface StockMovementGeneratorInterface
{
    // METHODS

    function registerStockMovement();

    // END METHODS

    // RELATIONS

    function stockMovement();

    // END RELATIONS
}