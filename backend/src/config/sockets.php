<?php 

require_once dirname(__DIR__, 2). '/vendor/autoload.php';

use Workerman\Worker;
use PHPSocketIO\SocketIO;

$GLOBALS['users'] = [];

$io = new SocketIO(3000);
$io->on('connection', function($socket) use ($io) {
    $GLOBALS['users'][$socket->id]['online'] = true;
    $socket->on('joined', function($chatId) use ($socket) {
        $socket->join($chatId);
    });
    $socket->on('leaved', function($chatId) use ($socket) {
        $socket->leave($chatId);
    });
    $socket->on('send', function($data) use ($socket) {
        $socket->to($data['to'])->emit('message', array('message' => $data['message'], 'from' => $data['from'], 'moment' => $data['moment']));
    });

    $socket->on('typing', function($data) use ($socket) {
        $socket->to($data['to'])->emit('typing', $data['value']);
    });

    $socket->on('disconnect', function($data) use ($socket) {
        $GLOBALS['users'][$socket->id]['online'] = false;
    });
});

Worker::runAll();

?>