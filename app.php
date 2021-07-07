<?php

define("ROOT", realpath(__DIR__));

require ROOT . '/vendor/autoload.php';

use Demo\Controller\PinController;
use Demo\Database\DB;
use Demo\Exceptions\NotFoundException;

try {
    DB::init();
    $pin = (new PinController())->handleRequest();
    http_response_code(200);
    echo $pin;
} catch (NotFoundException $e) {
    http_response_code(404);
    echo "No valid and unique pin was found.";
} catch (\Throwable $th) {
    http_response_code(500);
} finally {
    DB::close();
}
