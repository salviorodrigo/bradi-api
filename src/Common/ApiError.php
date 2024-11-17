<?php
declare(strict_types=1);

abstract class ApiError {
    public string $status;
    public string $title;
    public array $details;
}
