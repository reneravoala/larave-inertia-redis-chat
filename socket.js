var server = require('http').Server();

var Redis = require('ioredis');
var redis = new Redis();

// Create a new Socket.io instance
var io = require('socket.io')(server);

redis.psubscribe('*');

redis.on('pmessage', function (pattern, channel, message) {
    message = JSON.parse(message);

    console.log(message + channel);
    // Pass data to Socket.io every time we get a new message from Redis
    // "channel + ':' + message.event" is a unique channel id to broadcast to
    //
    // message.data corresponds to the $data variable in the MessageSent event
    // in Laravel
    io.emit(channel, message);
});

server.listen(3000);
