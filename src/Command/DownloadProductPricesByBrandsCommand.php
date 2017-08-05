<?php
namespace Screamy\BrrcImport\Command;

use Screamy\BrrcImport\Utils\ProductDownloadManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class DownloadProductPricesByBrandsCommand
 * @package Screamy\BrrcImport\Command
 */
class DownloadProductPricesByBrandsCommand extends Command
{
    use ContainerAwareTrait;

    protected function configure()
    {
        $this->setName('screamy:brrc:prices:download-by-brands')
            ->addArgument('filepath', InputArgument::REQUIRED, 'Output file')
            ->addArgument('brands', InputArgument::IS_ARRAY, 'Array of product brands');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('filepath');

        if (file_exists($filePath)) {
            $output->writeln('Prices are in process, exiting');
            return;
        }

        /**
         * @var ProductDownloadManager $manager
         */
        $manager = $this->container->get('screamy.brrc_import.utils.product_download_manager');

        $brands = $input->getArgument('brands');
        foreach ($brands as $brandId) {
            $output->writeln('Processing brand #' . $brandId);
            $manager->downloadPricesByBrandId($brandId, $filePath);
        }
    }
}
