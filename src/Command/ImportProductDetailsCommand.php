<?php

namespace Screamy\BrrcImport\Command;

use Screamy\BrrcImport\Utils\ProductDownloadManager;
use Screamy\BrrcImport\Utils\ProductImportManager;
use Screamy\PriceImporter\Mapper\ProductMapper;
use Symfony\Component\Config\Definition\Exception\Exception;
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
        $this->setName('screamy:brrc:product-details-import')
            ->addArgument('filepath', InputArgument::REQUIRED, 'Path to file with product ids');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $productIdsFilePath = $input->getArgument('filepath');

        if (!file_exists($productIdsFilePath)) {
            $output->writeln('No new products');
            return;
        }


        try {
            /**
             * @var ProductDownloadManager $manager
             */
            $manager = $this->container->get('screamy.brrc_import.utils.product_download_manager');

            /**
             * @var ProductMapper $productMapper
             */
            $productMapper = $this->container->get('screamy.brrc_import.product_details_mapper');

            /**
             * @var ProductImportManager $productImportManager
             */
            $productImportManager = $this->container->get('screamy.brrc_import.product_import_manager');

            foreach (file($productIdsFilePath) as $productId) {
                $detailedProductEntry = $manager->getProductDetailsById((int)$productId);
                $productImportManager->importProductDetails($productMapper->mapToProduct($detailedProductEntry));
            }
        } catch (Exception $e) {
            unlink($productIdsFilePath);
            throw $e;
        }

        unlink($productIdsFilePath);
    }
}
