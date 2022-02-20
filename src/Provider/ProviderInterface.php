<?php

namespace Dbout\Wp\Framework\Provider;

/**
 * Class Logger
 * @package Dbout\Wp\Framework\Provider
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
interface ProviderInterface
{

    /**
     * @return array
     */
    public function toOptionsArray(): array;
}