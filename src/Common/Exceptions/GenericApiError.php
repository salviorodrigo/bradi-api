<?php
declare(strict_types=1);

use BradiApi\Common\ApiError;

class GenericApiError extends ApiError {
    public $status = '418';
    public $title = 'Generic Api Error';
    public $details = ['message' => 'I\'m a teapot'];
}