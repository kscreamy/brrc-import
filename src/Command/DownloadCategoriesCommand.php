<?php

namespace Screamy\BrrcImport\Command;

use Screamy\BrrcImport\Utils\CategoryDownloadManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class DownloadCategoriesCommand
 * @package Screamy\BrrcImport\Command
 */
class DownloadCategoriesCommand extends Command
{
    use ContainerAwareTrait;

    protected function configure()
    {
        $this->setName('screamy:brrc:categories:download')
            ->addArgument('filepath', InputArgument::REQUIRED, 'Path to output file');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('filepath');

        /**
         * @var CategoryDownloadManager $manager
         */
        $manager = $this->container->get('screamy.brrc_import.utils.category_download_manager');

        $manager->downloadCategories($filePath);
    }
}