<?php 

require_once dirname(__DIR__, 2). '/vendor/autoload.php';

use Workerman\Worker;
use PHPSocketIO\SocketIO;

$GLOBALS['sessions'] = [];

$io = new SocketIO(3000);
$io->on('connection', function($socket) use ($io) { 

    $socket->on('enter', function($userId) use ($socket, $io) {
        $session = array(
            'user' => $userId,
            'socket' => $socket->id
        );
        $GLOBALS['sessions'] = array_values(array_filter($GLOBALS['sessions'], function($session) use($socket, $userId) {
            return $session['user']!=$userId;
        }));
        array_push($GLOBALS['sessions'], $session);
        $socket->emit('onlineUsers', $GLOBALS['sessions']);
        $socket->broadcast->emit('onlineUsers', $GLOBALS['sessions']);
    });

    $socket->on('disconnectUser', function($userId) use ($socket) {
        $GLOBALS['sessions'] = array_values(array_filter($GLOBALS['sessions'], function($session) use($socket, $userId) {
            return $session['user']!=$userId;
        }));
        $socket->emit('onlineUsers', $GLOBALS['sessions']);
        $socket->broadcast->emit('onlineUsers', $GLOBALS['sessions']);
    });

    $socket->on('joined', function($chatId) use ($socket) {
        $socket->join($chatId);
    });
    $socket->on('leaved', function($chatId) use ($socket) {
        $socket->leave($chatId);
    });
    $socket->on('send', function($data) use ($socket) {
        $socket->to($data['to'])->emit('message', $data);
    });

    $socket->on('typing', function($data) use ($socket) {
        $socket->to($data['to'])->emit('typing', $data['value']);
    });

    $socket->on('disconnect', function($data) use ($socket) {
        $GLOBALS['sessions'] = array_values(array_filter($GLOBALS['sessions'], function($session) use($socket) {
            return $session['socket']!=$socket->id;
        }));
        $socket->broadcast->emit('onlineUsers', $GLOBALS['sessions']);
    });
});

Worker::runAll();

?>