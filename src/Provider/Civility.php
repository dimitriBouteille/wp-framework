<?php

namespace Dbout\Wp\Framework\Provider;

/**
 * Class Civility
 * @package Dbout\Wp\Framework\Provider
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class Civility implements ProviderInterface
{

    const KEY_MR = 'mr';
    const KEY_MRS = 'mrs';

    /**
     * @inheritdoc
     */
    public function toOptionsArray(): array
    {
        return [
            ['key' => self::KEY_MR, 'label' => 'Monsieur'],
            ['key' => self::KEY_MRS, 'label' => 'Madame'],
        ];
    }
}