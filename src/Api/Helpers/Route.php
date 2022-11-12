<?php

namespace Dbout\Wp\Framework\Api\Helpers;

/**
 * Class Route
 * @package Dbout\Wp\Framework\Api\Helpers
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class Route
{

    /**
     * @param \WP_Error $error
     * @return \WP_REST_Response
     */
    public static function parseWpErrorToRestResponse(\WP_Error $error): \WP_REST_Response
    {
        $errorData = $error->get_error_data();
        $status = $errorData['status'] ?? 500;
        $errors = [];

        foreach ((array) $error->errors as $code => $messages) {
            foreach ((array) $messages as $message) {
                $errors[] = array(
                    'code' => $code,
                    'message' => $message,
                    'data' => $error->get_error_data($code),
                );
            }
        }

        $data = array_shift($errors);
        if (count($errors)) {
            $data['additional_errors'] = $errors;
        }

        $data = [
            'error' => $data,
        ];

        return new \WP_REST_Response($data, $status);
    }
}
