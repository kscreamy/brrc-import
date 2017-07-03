<?php
namespace Screamy\BrrcImport\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DownloadProductPricesByBrandsCommand
 * @package Screamy\BrrcImport\Command
 */
class DownloadProductPricesByBrandsCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('screamy:brrc:download-prices-by-brands')
            ->addArgument('brands', InputArgument::IS_ARRAY, 'Array of product brands');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $brands = $input->getArgument('brands');
    }
}
