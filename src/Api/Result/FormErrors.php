<?php

namespace Dbout\Wp\Framework\Api\Result;

/**
 * Class FormErrors
 * @package Dbout\Wp\Framework\Api\Result
 *
 * @author Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @copyright Copyright (c) 2022
 */
class FormErrors extends \WP_REST_Response
{

    public const KEY_ERRORS = 'formErrors';

    /**
     * @param array $errors
     * @param int $status
     * @param array $headers
     */
    public function __construct(array $errors = [], int $status = 400, array $headers = [])
    {
        parent::__construct([
            'success' => false,
            self::KEY_ERRORS => $errors
        ], $status, $headers);
    }

    /**
     * @param string $fieldKey
     * @param $error
     * @return $this
     */
    public function addError(string $fieldKey, $error): self
    {
        $data = $this->get_data();
        $data[self::KEY_ERRORS][$fieldKey] = $error;
        $this->set_data($data);
        return $this;
    }

    /**
     * @param array $errors
     * @return $this
     */
    public function setErrors(array $errors): self
    {
        $data = $this->get_data();
        $data[self::KEY_ERRORS] = $errors;
        $this->set_data($data);
        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        $data = $this->get_data();
        $errors = $data[self::KEY_ERRORS] ?? null;
        return is_array($errors) ? $errors : [];
    }
}
