<?php

namespace Dbout\Wp\Framework\Provider;

/**
 * Class YesNo
 * @package Dbout\Wp\Framework\Provider
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class YesNo implements ProviderInterface
{

    const KEY_YES = 'yes';
    const KEY_NO = 'no';

    /**
     * @inheritdoc
     */
    public function toOptionsArray(): array
    {
        return [
            ['value' => self::KEY_YES, 'label' => __('Yes')],
            ['value' => self::KEY_NO, 'label' => __('No')],
        ];
    }
}
