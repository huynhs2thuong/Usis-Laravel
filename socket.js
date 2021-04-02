var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();

redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    io.sockets.in(channel).emit(message.event, message.data);
});

io.sockets.on('connection', function (socket) {
    console.log('New client connected');
    socket.on('subscribe', function (data) {
        redis.subscribe(data);
        socket.join(data);
        console.log('Subscribe to channel', data);
    });
    socket.on('unsubscribe', function (data) {
        socket.leave(data);
        console.log('Unsubscribe from channel', data);
    });
    socket.on('disconnect', function () {
        console.log('Disconnect');
    });
});

http.listen(8890, function() {
    console.log('Listening on port 8890');
});
