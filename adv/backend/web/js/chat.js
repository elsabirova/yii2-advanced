let port = wsPort ? wsPort : 8080,
    conn = new WebSocket('ws://localhost:' + port);

conn.onopen = function(e) {
    console.log("Connection  established!");
};

conn.onerror = function(e) {
    console.log("Connection fail!");
};

conn.onmessage = function(e) {
    let $el = $('li.messages-menu ul.menu li:first').clone();
    $el.find('p').text(e.data);
    $el.find('h4').text('Websocket user');
    $el.prependTo('li.messages-menu ul.menu');
    
    let cnt = $('li.messages-menu ul.menu li').length;
    $('li.messages-menu span.label-success').text(cnt);
    $('li.messages-menu li.header').text('You have ' + cnt + ' messages');
    
    let chat = $('#chat-area');
    chat.val(e.data + '\n' + chat.val());
};

$(document).ready(function () {
    $('.chat-message-send').on('click', function (e) {
        let msg = $('.chat-message').val();
        conn.send(msg);
    });
});