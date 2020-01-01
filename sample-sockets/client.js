const io = require('socket.io-client');

const socket = io('http://localhost:3000');

socket.emit('joined', 'MYCHAT');

socket.on('message', (message) => {
    console.log(message); // false
});

setInterval(() => {
    socket.emit('send', {
        to: 'MYCHAT',
        message: 'Hello!'
    })
}, 500)