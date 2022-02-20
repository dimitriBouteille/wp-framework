<?php

namespace Dbout\Wp\Framework\Notice;

/**
 * Class Notice
 * @package Dbout\Wp\Framework\Notice
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class Notice
{

    const TYPE_ERROR = 'error';
    const TYPE_SUCCESS = 'success';
    const TYPE_WARNING = 'warning';
    const TYPE_INFO = 'info';

    /**
     * @var string|null
     */
    protected ?string $type;

    /**
     * @var string|null
     */
    protected ?string $message;

    /**
     * @var bool
     */
    protected bool $dismissible = true;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Notice
     */
    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Notice
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDismissible(): bool
    {
        return $this->dismissible;
    }

    /**
     * @param bool $dismissible
     * @return Notice
     */
    public function setDismissible(bool $dismissible): self
    {
        $this->dismissible = $dismissible;
        return $this;
    }
}
