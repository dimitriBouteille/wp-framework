<?php

namespace Dbout\Wp\Framework\Helper;

use Symfony\Component\Mime\MimeTypes;

/**
 * Class File
 * @package Dbout\Wp\Framework\Helper
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class File
{

    /**
     * @param string|null $file
     * @return bool
     */
    public static function isSvg(?string $file): bool
    {
        $mimeType = self::getMimeType($file);
        if (!$mimeType) {
            return false;
        }

        return in_array($mimeType, [
            'image/svg+xml',
            'text/html',
            'text/plain',
            'image/svg',
        ]);
    }

    /**
     * @param string|null $file
     * @return bool
     */
    public static function isVideo(?string $file): bool
    {
        $mimeType = self::getMimeType($file);
        if (!$mimeType) {
            return false;
        }

        return strpos($mimeType, 'video') === 0;
    }

    /**
     * @param string|null $file
     * @return bool
     */
    public static function isImage(?string $file): bool
    {
        $mimeType = self::getMimeType($file);
        if (!$mimeType) {
            return false;
        }

        return strpos($mimeType, 'image') === 0;
    }

    /**
     * @param string|null $file
     * @return bool
     */
    protected static function exist(?string $file): bool
    {
        return empty($file) || !file_exists($file);
    }

    /**
     * @param string|null $file
     * @return string|null
     */
    public static function getMimeType(?string $file): ?string
    {
        if(self::exist($file)) {
            return null;
        }

        $mimeType = null;
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        if ($extension) {
            $mimeType = (new MimeTypes())->guessMimeType($extension);
        }

        return $mimeType;
    }

    /**
     * @param $size
     * @return string|null
     */
    public static function formatSize($size): ?string
    {
        $units = [ 'o', 'Ko', 'Mo', 'Go', 'To', 'Po', 'Eo', 'Zo', 'Yo'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
}