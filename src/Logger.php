<?php

namespace Dbout\Wp\Framework;

use Monolog\Handler\StreamHandler;

/**
 * Class Logger
 * @package Dbout\Wp\Framework
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
abstract class Logger
{

    /**
     * @var string|null
     */
    protected ?string $fileName;

    /**
     * @var \Monolog\Logger|null
     */
    protected ?\Monolog\Logger $logger = null;

    /**
     * @var array
     */
    protected static array $instances = [];

    public function __construct()
    {
        $this->init();
    }

    /**
     * Init logger
     * @return void
     */
    protected function init(): void
    {
        if ($this->logger) {
            return;
        }

        $logger = new \Monolog\Logger('core');
        $logger->pushHandler(new StreamHandler($this->fileName));
        $this->logger = $logger;
    }

    /**
     * @return static
     */
    public static function instance(): self
    {
        $class = get_called_class();
        if (!key_exists($class, self::$instances)) {
            self::$instances[$class] = new $class();
        }

        return self::$instances[$class];
    }

    /**
     * @param $message
     * @param array|null $context
     * @return $this
     */
    public function error($message, ?array $context = []): self
    {
        return $this->add($message, $context, 'error');
    }

    /**
     * @param $message
     * @param array|null $context
     * @return $this
     */
    public function critical($message, ?array $context = []): self
    {
        return $this->add($message, $context, 'critical');
    }

    /**
     * @param $message
     * @param array|null $context
     * @return $this
     */
    public function info($message, ?array $context = []): self
    {
        return $this->add($message, $context, 'info');
    }

    /**
     * @param $message
     * @param $context
     * @param $callback
     * @return $this
     */
    protected function add($message, $context, $callback): self
    {
        if ($message instanceof \Exception) {
            $message = $message->getMessage();
            $context['exception'] = $message;
        }

        if (!is_array($context)) {
            $context = [];
        }

        $this->logger->$callback($message, $context);
        return $this;
    }
}
