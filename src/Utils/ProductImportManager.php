<?php
namespace Screamy\BrrcImport\Utils;

/**
 * Class ProductImportManager
 * @package Screamy\BrrcImport\Utils
 */
class ProductImportManager
{
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
    public function importPricesByBrandId($brandId, $outputFilePath)
    {
        $url = sprintf($this->urlPattern, $this->secret, $brandId);

        $channel = curl_init();
        curl_setopt($channel, CURLOPT_URL, $url);
        curl_setopt($channel, CURLOPT_FOLLOWLOCATION, $url);

        $data = curl_exec($channel);
        $error = curl_error($channel);
        curl_close($channel);

        if ($error) {
            throw new \Exception($error);
        }

        $file = fopen($outputFilePath, "w+");

        if (!$file) {
            throw new \Exception('Error opening file ' . $outputFilePath . ' for writing');
        }
        fputs($file, $data);
        fclose($file);
    }
}
