<?php

namespace Dbout\Wp\Framework\Form;

use Dbout\WpHooks\Facade\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractForm
 * @package Dbout\Wp\Framework\Form
 *
 * @method static string action();
 * @method static string nonce();
 * @method static string nonceName();
 * @method static string nonceFieldName();
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
abstract class AbstractForm
{

    /**
     * @var self[]
     */
    protected static array $instances = [];

    /**
     * Form action
     * ie : my-contact-form
     * @var string
     */
    protected string $action;

    /**
     * Form nonce name
     * @var string
     */
    protected string $nonceName;

    /**
     * If true, Fires ajax actions for logged-out users.
     * @var bool
     */
    protected bool $noLoggedUser = true;

    /**
     * Form nonce field name
     * @var string|null
     */
    protected ?string $nonceFieldName = '_token';

    /**
     * @return string
     */
    public function getAction(): ?string
    {
        return $this->action;
    }

    /**
     * @return string|null
     */
    public function getNonceName(): ?string
    {
        return $this->nonceName;
    }

    /**
     * @return string|null
     */
    public function getNonceFieldName(): ?string
    {
        return $this->nonceFieldName;
    }

    /**
     * @param Request $request
     * @return Response
     */
    protected abstract function execute(Request $request): Response;

    /**
     * @return bool
     */
    protected function isAllowed(): bool
    {
        return true;
    }

    /**
     * @return void
     */
    public function submit(): void
    {
        $request = Request::createFromGlobals();
        if(!$this->isAllowed()) {
            $response = $this->notAllowed();
        } else if(wp_verify_nonce($request->get($this->nonceFieldName), $this->nonceName, false) === false) {
            $response = $this->invalidNonce();
        } else {
            $response = $this->execute($request);
        }

        $this->sendResponse($response);
    }

    /**
     * @return Response
     */
    protected function invalidNonce(): Response
    {
        return new JsonResponse([
            'error' => __('Le formulaire n\'est pas valide . Veuillez rafraichir la page pour tenter de corriger le problème . Si le problème persiste, veuillez réessayer dans quelques instants.'),
        ], 400);
    }

    /**
     * @return Response
     */
    protected function notAllowed(): Response
    {
        return new JsonResponse([
            'error' => __("Droit insuffisant"),
        ], 401);
    }

    /**
     * Call wp_create_nonce function
     *
     * @return string
     */
    public function getNonce(): string
    {
        return wp_create_nonce($this->getNonceName());
    }

    /**
     * @return array
     */
    public function getDataForJson(): array
    {
        return [
            'action' => $this->getAction(),
            $this->getNonceFieldName() => $this->getNonce(),
        ];
    }

    /**
     * @return string
     */
    public function renderFields(): string
    {
        $html = '';
        foreach ($this->getDataForJson() as $name => $value) {
            $html .= sprintf(
                '<input type="hidden" name="%s" value="%s" />',
                $name,
                $value);
        }

        return $html;
    }

    /**
     * Send response
     *
     * @param Response $response
     */
    protected function sendResponse(Response $response): void
    {
        $response->send();
        die;
    }

    /**
     * Register form
     */
    public static function register(): void
    {
        $instance = static::getInstance();
        $callBack = [$instance, 'submit'];
        Action::add('wp_ajax_'. $instance->getAction(), $callBack);
        if($instance->noLoggedUser) {
            Action::add('wp_ajax_nopriv_'. $instance->getAction(), $callBack);
        }
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        $class = get_called_class();
        if(!key_exists($class, self::$instances)) {
            self::$instances[$class] = new static();
        }

        return self::$instances[$class];
    }

    /**
     * @param $name
     * @param $arguments
     * @return string|null
     */
    public static function __callStatic($name, $arguments)
    {
        $instance = static::getInstance();
        switch ($name) {
            case 'action':
                return $instance->getAction();
            case 'nonce':
                return $instance->getNonce();
            case 'nonceName':
                return $instance->getNonceName();
            case 'nonceFieldName':
                return $instance->getNonceFieldName();
        }

        return null;
    }
}
