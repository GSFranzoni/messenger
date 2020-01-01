<?php 

require_once dirname(__DIR__, 2). '/vendor/autoload.php';

use Workerman\Worker;
use PHPSocketIO\SocketIO;

$io = new SocketIO(3000);
$io->on('connection', function($socket) use ($io) {
    $socket->on('joined', function($chatId) use ($socket) {
        $socket->join($chatId);
    });
    $socket->on('send', function($data) use ($socket, $io) {
        $socket->to($data['to'])->emit('message', array('message' => $data['message'], 'from' => $data['from']));
    });
});

Worker::runAll();

?>