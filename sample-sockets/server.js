const io = require('socket.io')(3000);

io.on('connection', () => {
  io.emit('message', 'Hello, man!');
});