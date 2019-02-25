let port = wsPort ? wsPort : 8080,
    conn = new WebSocket('ws://localhost:' + port);

conn.onopen = function(e) {
    console.log("Connection  established!");
};

conn.onerror = function(e) {
    console.log("Connection fail!");
};

conn.onmessage = function(e) {
    let $menu = $('.messages-menu .menu');
    
    $menu.append(`<li>
                    <a href="#">
                        <div class="pull-left">
                            <img src="/img/user4-128x128.jpg" class="img-circle"
                                 alt="user image"/>
                        </div>
                        <h4>
                            Websocket user
                            <small><i class="fa fa-clock-o"></i> Today</small>
                        </h4>
                        <p>${e.data}</p>
                    </a>
                </li>`);
    
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