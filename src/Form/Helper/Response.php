<?php

namespace Dbout\Wp\Framework\Form\Helper;

/**
 * Trait Response
 * @package Dbout\Wp\Framework\Form\Helper
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
trait Response
{

    /**
     * Returns json form errors
     * @param array $errors
     * @return JsonResponse
     */
    protected function formErrors(array $errors): JsonResponse
    {
        return new JsonResponse(['errors' => $errors], 400);
    }

    /**
     * Returns json error message
     * @param string $error
     * @return JsonResponse
     */
    protected function error(string $error): JsonResponse
    {
        return new JsonResponse(['error' => $error], 400);
    }

    /**
     * Returns json custom message
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function message(string $message, int $code = 200): JsonResponse
    {
        return new JsonResponse(['message' => $message, 'code' => $code,], $code);
    }

    /**
     * Returns json html content
     * @param string|null $html
     * @param int $code
     * @return JsonResponse
     */
    protected function html(?string $html, int $code = 200): JsonResponse
    {
        return new JsonResponse(['html' => $html, 'code' => $code,], $code);
    }
}
