<?php 

require_once dirname(__DIR__, 2). '/vendor/autoload.php';

use Workerman\Worker;
use PHPSocketIO\SocketIO;

$io = new SocketIO(3000);
$io->on('connection', function($socket) use ($io) {
    $socket->on('joined', function($chatId) use ($socket) {
        print 'joined';
        $socket->join($chatId);
    });
    $socket->on('send', function($data) use ($socket, $io) {
        print 'sending';
        $socket->to($data['to'])->emit('message', array('message' => $data['message'], 'from' => $data['from'], 'moment' => $data['moment']));
    });

    $socket->on('typing', function($data) use ($socket, $io) {
        print 'typing';
        $socket->to($data['to'])->emit('typing', $data['value']);
    });
});

Worker::runAll();

?>