<?php

namespace Screamy\BrrcImport\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportProductPricesCommand
 * @package Screamy\BrrcImport\Command
 */
class ImportProductPricesCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('screamy:brrc:product-price-import')
            ->addArgument('filepath', InputArgument::REQUIRED, 'Path to file with product prices');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('filepath');
    }

    /**
     * {@inheritdoc}

    public function emitProducts(ProductIterator $products)
    {
        foreach($products as $product)
        {
            if ($this->productExists($product->getSku())) {
                $this->updateProductPrices($product->getSku(), $product->getPrices());
            } else {
                $this->importProduct($product);
            }
        }
    }
     */
}
