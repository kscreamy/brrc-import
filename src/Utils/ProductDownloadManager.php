<?php
namespace Screamy\BrrcImport\Utils;

/**
 * Class ProductDownloadManager
 * @package Screamy\BrrcImport\Utils
 */
class ProductDownloadManager
{
    use DownloadTrait;
    /**
     * @var string
     */
    private $urlPattern = 'http://brrc.ru/api/v1.0/?cmd=getbrandproducts&key=%s&brandid=%u&type=csv';

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
     * @param int $brandId
     * @param string $outputFilePath
     * @throws \Exception
     */
    public function downloadPricesByBrandId($brandId, $outputFilePath)
    {
        $url = sprintf($this->urlPattern, $this->secret, $brandId);

        $data = $this->downloadIntoMemory($url);

        $file = fopen($outputFilePath, "a+");

        if (!$file) {
            throw new \Exception('Error opening file ' . $outputFilePath . ' for writing');
        }
        fputs($file, $data);
        fclose($file);
    }
}
