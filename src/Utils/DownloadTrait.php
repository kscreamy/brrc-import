<?php

namespace Screamy\BrrcImport\Utils;

/**
 * Class DownloadTrait
 * @package Screamy\BrrcImport\Utils
 */
trait DownloadTrait
{
    /**
     * @param string $url
     */
    private function downloadIntoMemory($url)
    {
        $channel = curl_init();
        curl_setopt($channel, CURLOPT_URL, $url);
        curl_setopt($channel, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($channel);
        $error = curl_error($channel);
        curl_close($channel);

        $data = preg_replace('#^(.+?\n)#', '', $data); //header replacement

        if ($error) {
            throw new \Exception($error);
        }

        return $data;
    }
}
