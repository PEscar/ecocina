<?php

namespace App\Interfaces;

interface StockMovementLineGeneratorInterface
{
    // METHODS

    function registerStockMovementLine();

    // END METHODS

    // RELATIONS

    function stockMovementLine();

    // END RELATIONS
}