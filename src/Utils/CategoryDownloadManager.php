<?php
namespace Screamy\BrrcImport\Utils;

/**
 * Class CategoryDownloadManager
 * @package Screamy\BrrcImport\Utils
 */
class CategoryDownloadManager
{
    use DownloadTrait;
    /**
     * @var string
     */
    private $urlPattern = 'http://brrc.ru/api/v1.0/?cmd=getallsections&key=%s&type=csv';

    /**
     * @var string
     */
    private $secret;

    /**
     * ProductImportManager constructor.
     * @param string $secret
     */
    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @param string $outputFilePath
     * @throws \Exception
     */
    public function downloadCategories($outputFilePath)
    {
        $url = sprintf($this->urlPattern, $this->secret);

        $data = $this->downloadIntoMemory($url);

        $file = fopen($outputFilePath, "a+");

        if (!$file) {
            throw new \Exception('Error opening file ' . $outputFilePath . ' for writing');
        }
        fputs($file, $data);
        fclose($file);
    }
}
