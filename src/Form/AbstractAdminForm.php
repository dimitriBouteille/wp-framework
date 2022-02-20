<?php

namespace Dbout\Wp\Framework\Form;

/**
 * Class AbstractAdminForm
 * @package Dbout\Wp\Framework\Form
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
abstract class AbstractAdminForm extends AbstractForm
{

    /**
     * @inheritdoc
     */
    protected bool $noLoggedUser = false;
}
