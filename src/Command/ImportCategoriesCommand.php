<?php

namespace Screamy\BrrcImport\Command;

use Screamy\PriceImporter\Utils\CategoryImporter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class ImportCategoriesCommand
 * @package Screamy\BrrcImport\Command
 */
class ImportCategoriesCommand extends Command
{
    use ContainerAwareTrait;


    protected function configure()
    {
        $this->setName('screamy:brrc:categories:import')
            ->addArgument('filepath', InputArgument::REQUIRED, 'Path to file with categories');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('filepath');

        $this->container->get('screamy.brrc_import.category_import_manager')->importCategories($filePath);
    }
}
