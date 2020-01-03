const io = require('socket.io-client');

const socket = io('http://localhost:3000');

const user = {
    id: 2,
    name: 'Maria'
}

// socket.emit('joined', 'MYCHAT');
// socket.on('message', (message) => {
//     console.log(message); // false
// });
// socket.emit('send', {
//     to: 'MYCHAT',
//     message: 'Hello!',
//     from: user,
//     moment: ''
// })

socket.on('onlineUsers', (users) => {
    console.clear();
    console.log(users)
})

socket.on('connect', () => {
    console.log('conectado')
    socket.emit('enter', user);
})
