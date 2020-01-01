const io = require('socket.io-client');

const socket = io('http://localhost:3000');

socket.emit('joined', 'MYCHAT1');

socket.on('message', (message) => {
    console.log(message); // false
});

socket.emit('send', {
    to: 'MYCHAT1',
    message: 'Hello!'
})
