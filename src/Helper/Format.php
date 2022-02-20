<?php

namespace Dbout\Wp\Framework\Helper;

use Carbon\Carbon;

/**
 * Class Format
 * @package Dbout\Wp\Framework\Helper
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class Format
{

    /**
     * @param string|null $firstName
     * @param string|null $lastName
     * @return string|null
     */
    public static function fullName(?string $firstName, ?string $lastName): ?string
    {
        if (!empty($firstName) && !empty($lastName)) {
            return ucfirst($firstName) . ' ' . mb_strtoupper($lastName);
        } else if (!empty($firstName)) {
            return ucfirst($firstName);
        }

        return mb_strtolower($lastName);
    }

    /**
     * @param string|null $phone
     * @return string|null
     */
    public static function phone(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }
        $i = 0;
        $j = 0;
        $newPhone = "";
        while ($i <strlen($phone)) {
            if ($j < 2) {
                if (preg_match('/^[0-9]$/', $phone[$i])) {
                    $newPhone .= $phone[$i];
                    $j++;
                }
                $i++;
            } else {
                $newPhone .= " ";
                $j=0;
            }
        }

        return $newPhone;
    }

    /**
     * @param string|null $time
     * @return string|null
     */
    public static function time(?string $time): ?string
    {
        if (\is_string($time)) {
            return \str_replace(':', 'h', $time);
        }

        if ($time instanceof Carbon) {
            return $time->format('H') . 'h' . $time->format('i');
        }

        return null;
    }
}