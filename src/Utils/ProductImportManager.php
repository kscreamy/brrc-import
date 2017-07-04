<?php

namespace Screamy\BrrcImport\Utils;

use Screamy\BrrcImport\Exception\ProductNotFoundException;
use Screamy\PriceImporter\Model\Product;

/**
 * Class ProductImportManager
 * @package Screamy\BrrcImport\Utils
 */
class ProductImportManager
{
    /**
     * @param string $sku
     * @param array $prices
     * @throws ProductNotFoundException
     * @throws \Exception
     */
    public function importProductPrices($sku, array $prices)
    {

    }

    /**
     * @param Product $product
     * @throws \Exception
     */
    public function importProduct(Product $product)
    {
    }
}
