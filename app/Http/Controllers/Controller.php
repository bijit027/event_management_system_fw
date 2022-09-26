<?php

namespace EventManagementSystem\App\Http\Controllers;

use EventManagementSystem\Framework\Http\Controller as BaseController;
use EventManagementSystem\Framework\Validator\ValidationException;

abstract class Controller extends BaseController
{
    public function validate($data, $rules, $messages = [])
    {
        try {
            $validator = $this->app->validator->make($data, $rules, $messages);

            if ($validator->validate()->fails()) {
                throw new ValidationException(
                    'Unprocessable Entity!',
                    422,
                    null,
                    $validator->errors()
                );
            }

            return $data;
        } catch (ValidationException $e) {

            if (defined('REST_REQUEST') && REST_REQUEST) {
                throw $e;
            };

            $this->app->doCustomAction('handle_exception', $e);
        }
    }
}
