<?php

namespace Screamy\BrrcImport\Command;

use Screamy\PriceImporter\Utils\CategoryImporter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportCategoriesCommand
 * @package Screamy\BrrcImport\Command
 */
class ImportCategoriesCommand extends Command
{
    /**
     * @var CategoryImporter
     */
    private $categoryImporter;

    /**
     * ImportCategoriesCommand constructor.
     * @param CategoryImporter $categoryImporter
     */
    public function __construct(CategoryImporter $categoryImporter)
    {
        parent::__construct();
        $this->categoryImporter = $categoryImporter;
    }

    protected function configure()
    {
        $this->setName('screamy:brrc:categories-import')
            ->addArgument('filepath', InputArgument::REQUIRED, 'Path to file with categories');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('filepath');

        $this->categoryImporter->importCategories($filePath);
    }
}
