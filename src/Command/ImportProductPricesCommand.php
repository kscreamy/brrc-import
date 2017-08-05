<?php

namespace Screamy\BrrcImport\Command;

use Screamy\BrrcImport\Utils\ProductImportManager;
use Screamy\PriceImporter\Exception\ProductNotFoundException;
use Screamy\PriceImporter\Mapper\ProductMapper;
use Screamy\PriceImporter\Parser\IteratorProviderInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
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
        $this->setName('screamy:brrc:prices:import')
            ->addArgument('filepath', InputArgument::REQUIRED, 'Path to file with product prices');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('filepath');

        $idsFilePath = 'web/upload/new_products.csv';
        if (!file_exists($filePath)) {
            $output->writeln('No prices downloaded, exiting');
            return;
        }
        if (file_exists($idsFilePath)) {
            $output->writeln('Product details are in process, exiting');
            return;
        }

        try {
            /**
             * @var ProductMapper $productMapper
             */
            $productMapper = $this->container->get('screamy.brrc_import.product_mapper');
            /**
             * @var IteratorProviderInterface $iteratorProvider
             */
            $iteratorProvider = $this->container->get('screamy.brrc_import.product_iterator_provider');
            /**
             * @var ProductImportManager $productImportManager
             */
            $productImportManager = $this->container->get('screamy.brrc_import.product_import_manager');

            foreach ($iteratorProvider->getIterator($filePath) as $productPriceEntry) {
                $product = $productMapper->mapToProduct($productPriceEntry);
                try {
                    $productImportManager->importProductPrices($product->getSku(), $product->getPrices());
                } catch (ProductNotFoundException $e) {
                    $productImportManager->importProduct($product);
                }
            }
        } catch (Exception $e) {
            unlink($filePath);
            throw $e;
        }
        unlink($filePath);
    }
}
