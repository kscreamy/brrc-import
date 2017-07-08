<?php

namespace Screamy\BrrcImport\Utils;

use Screamy\BrrcImport\Exception\ProductNotFoundException;
use Screamy\PriceImporter\Model\Product;

/**
 * Class ProductImportManager
 * @package Screamy\BrrcImport\Utils
 * todo move to doctrine integration bundle
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
        throw new ProductNotFoundException();
    }

    /**
     * @param Product $product
     * @throws \Exception
     */
    public function importProduct(Product $product)
    {
        //postpone if not excluded
        $pointer = fopen('upload/new_products.csv', 'a+');
        if (!$pointer) {
            throw new \Exception();
        }
        fputs($pointer, $product->getId()."\n");

        fclose($pointer);
    }

    public function importProductDetails(Product $product)
    {

    }
}
