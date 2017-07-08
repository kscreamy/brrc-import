<?php
namespace Screamy\BrrcImport\Utils;

/**
 * Class ProductDownloadManager
 * @package Screamy\BrrcImport\Utils
 */
class ProductDownloadManager
{
    use DownloadTrait, CsvValidationTrait;
    /**
     * @var string
     */
    private $pricesUrlPattern = 'http://brrc.ru/api/v1.0/?cmd=getbrandproducts&key=%s&brandid=%u&type=csv';

    private $productDetailsUrlPattern = 'http://brrc.ru/api/v1.0/?cmd=getproduct&key=%s&productid=%u&type=csv';
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
        $url = sprintf($this->pricesUrlPattern, $this->secret, $brandId);

        $data = $this->downloadIntoMemory($url);

        $this->validateCsv($data);

        $file = fopen($outputFilePath, "a+");

        if (!$file) {
            throw new \Exception('Error opening file ' . $outputFilePath . ' for writing');
        }
        fputs($file, $data);
        fclose($file);
    }

    /**
     * @param int $id
     * @param $outputFilePath
     * @throws \Exception
     */
    public function downloadProductDetailsById($id, $outputFilePath)
    {
        $url = sprintf($this->productDetailsUrlPattern, $this->secret, $id);

        $data = $this->downloadIntoMemory($url);

        $this->validateCsv($data);

        $file = fopen($outputFilePath, "a+");

        $row = [];

        $fieldTitles = [
            'ID товара',
            'Имя',
            'Путь к детальной картинке товара',
            'ID раздела в котором находится товар',
            'Артикул товара',
            'Бренд товара',
            'Масштаб',
            'Комплектация',
            'Тип двигателя',
            'Тип ракеты',
            'Размер',
            'Тип танка',
            'Оставшееся количество',
            'Розничная цена',
            'Оптовая цена'
        ];

        foreach (str_getcsv($data, ';') as $fieldNum => $field) {
            if (!isset($fieldTitles[$fieldNum])) continue;
            $row[] = $fieldTitles[$fieldNum];
            $row[] = $field;
        }

        if (!$file) {
            throw new \Exception('Error opening file ' . $outputFilePath . ' for writing');
        }
        fputcsv($file, $row, ';');
        fclose($file);
    }
}
