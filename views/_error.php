<?php
/**
 * @var int $code
 * @var string $message
 */


function buildErrorMessage(int $code): string
{
    return match ($code) {
        404 => "Page not found.",
        403, 401 => "You are not authorized to access this page.",
        default => "Something went wrong. Please try again later.",
    };
}

$isDev = $_ENV['MODE'] === 'development';
$message = $isDev ? $message : buildErrorMessage($code);


?>

<div class="error-container">
    <p>Oops!</p>
    <p><?= $code ?></p>
    <p><?= $message ?></p>
</div>
