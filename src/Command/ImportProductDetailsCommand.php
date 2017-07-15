<?php

namespace Screamy\BrrcImport\Command;

use Screamy\BrrcImport\Utils\ProductImportManager;
use Screamy\PriceImporter\Mapper\ProductIterator;
use Screamy\PriceImporter\Mapper\ProductMapper;
use Screamy\PriceImporter\Parser\IteratorProviderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class ImportProductDetailsCommand
 * @package Screamy\BrrcImport\Command
 */
class ImportProductDetailsCommand extends Command
{
    use ContainerAwareTrait;

    protected function configure()
    {
        $this->setName('screamy:brrc:product:details-import')
            ->addArgument('filepath', InputArgument::REQUIRED, 'Path to file with product details');
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
        $productMapper = $this->container->get('screamy.brrc_import.product_details_mapper');

        /**
         * @var IteratorProviderInterface $iteratorProvider
         */
        $iteratorProvider = $this->container->get('screamy.brrc_import.product_iterator_provider');

        $products = new ProductIterator($iteratorProvider->getIterator($filePath), $productMapper);

        /**
         * @var ProductImportManager $productImportManager
         */
        $productImportManager = $this->container->get('screamy.brrc_import.product_import_manager');

        foreach ($products as $product) {
            $productImportManager->importProductDetails($product);
        }
    }
}
