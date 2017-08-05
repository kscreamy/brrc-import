<?php

namespace Screamy\BrrcImport\Utils;

use Screamy\PriceImporter\Exception\ProductNotFoundException;
use Screamy\PriceImporter\Model\Product;
use Screamy\PriceImporter\Utils\ProductImportManagerInterface as ProductImporter;
use Screamy\PriceImporter\Utils\ProductPricesImportManagerInterface as PricesImporter;

/**
 * Class ProductImportManager
 * @package Screamy\BrrcImport\Utils
 */
class ProductImportManager implements ProductImporter, PricesImporter
{
    /**
     * @var ProductImporter
     */
    private $productImporter;

    /**
     * @var PricesImporter
     */
    private $pricesImporter;

    /**
     * ProductImportManager constructor.
     * @param ProductImporter $productImporter
     * @param PricesImporter $pricesImporter
     */
    public function __construct(ProductImporter $productImporter, PricesImporter $pricesImporter)
    {
        $this->productImporter = $productImporter;
        $this->pricesImporter = $pricesImporter;
    }

    /**
     * {@inheritdoc}
     */
    public function importProductPrices($sku, array $prices)
    {
        $this->pricesImporter->importProductPrices($sku, $prices);
    }

    /**
     * {@inheritdoc}
     */
    public function importProduct(Product $product)
    {
        //postpone if not excluded
        $pointer = fopen('web/upload/new_products.csv', 'a+');
        if (!$pointer) {
            throw new \Exception();
        }
        fputs($pointer, $product->getId() . "\n");

        fclose($pointer);
    }

    /**
     * @param Product $product
     */
    public function importProductDetails(Product $product)
    {
        $this->productImporter->importProduct($product);
    }
}
