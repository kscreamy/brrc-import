<?php

namespace Screamy\BrrcImport\Command;

use Screamy\BrrcImport\Utils\ProductDownloadManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class DownloadProductDetailsCommand
 * @package Screamy\BrrcImport\Command
 */
class DownloadProductDetailsCommand extends Command
{
    use ContainerAwareTrait;

    protected function configure()
    {
        $this->setName('screamy:brrc:download-product-details')
            ->addArgument('filepath', InputArgument::REQUIRED, 'Path to file with product ids')
            ->addArgument('details-filepath', InputArgument::REQUIRED,
                'Path to file where product details will be stored');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $detailsFilePath = $input->getArgument('details-filepath');

        $filePath = $input->getArgument('filepath');

        /**
         * @var ProductDownloadManager $manager
         */
        $manager = $this->container->get('screamy.brrc_import.utils.product_download_manager');

        $productIds = file($filePath);

        foreach ($productIds as $productId) {

            $manager->downloadProductDetailsById((int)$productId, $detailsFilePath);
        }
    }
}
