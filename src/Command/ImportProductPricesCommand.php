<?php

namespace Screamy\BrrcImport\Command;

use Screamy\PriceImporter\Mapper\ProductMapper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class ImportProductPricesCommand
 * @package Screamy\BrrcImport\Command
 */
class ImportProductPricesCommand extends Command
{
    use ContainerAwareTrait;

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

        /**
         * @var ProductMapper $productMapper
         */
        $productMapper = $this->container->get('screamy.brrc_import.product_mapper');

        //$products = $productMapper->ma
        /*
        foreach($products as $product)
        {
            if ($this->productExists($product->getSku())) {
                $this->updateProductPrices($product->getSku(), $product->getPrices());
            } else {
                $this->importProduct($product);
            }
        }
        */
    }

}
