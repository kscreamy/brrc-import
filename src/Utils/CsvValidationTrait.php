<?php

namespace Screamy\BrrcImport\Utils;

/**
 * Class CsvValidationTrait
 * @package Screamy\BrrcImport\Utils
 */
trait CsvValidationTrait
{
    /**
     * @param string $string
     * @throws \Exception
     */
    private function validateCsv($string)
    {
        if (json_decode($string)) {
            throw new \Exception($string);
        }
    }
}
