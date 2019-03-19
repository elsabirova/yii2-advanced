let port = wsPort ? wsPort : 8080,
    conn = new WebSocket('ws://localhost:' + port);

conn.onopen = function(e) {
    const data = {
        setProjectId: window.location.pathname.split('/')[3],
    };
    conn.send(JSON.stringify(data));
    
    console.log("Connection  established!");
};

conn.onerror = function(e) {
    console.log("Connection fail!");
};

conn.onmessage = function(e) {
    let $menu = $('.messages-menu .menu');
    let data = JSON.parse(e.data);
    
    if(data.author != 'Me') {
        $menu.append(`<li>
                    <a href="#">
                        <div class="pull-left">
                            <img src="${data.avatar}" class="img-circle" alt="user image"/>
                        </div>
                        <h4>
                            <small><i class="fa fa-clock-o"></i> ${data.date} </small>
                        </h4>
                        <p>${data.msg}</p>
                    </a>
                </li>`);
    }
    
    let cnt = $('li.messages-menu ul.menu li').length;
    $('li.messages-menu span.label-success').text(cnt);
    $('li.messages-menu li.header').text('You have ' + cnt + ' messages');
    
    let chatArea = $('#chat-area');
    let chat = `<div class="chat-img pull-left">
                    <img src="${data.avatar}" class="img-circle" alt="user image"/>
                </div>
                <div class="chat-author">${data.author} <span class="chat-time"><i class="fa fa-clock-o"></i>${data.date} </span></div>
                <div>${data.msg}</div>`
                + chatArea.html();
    chatArea.html(chat);
};

$(document).ready(function () {
    $('.chat-message-send').on('click', function (e) {
        let msg = $('.chat-message');
        
        const data = {
            authorId: wsUserId,
            projectId: wsProjectId,
            msg: msg.val(),
        };
        conn.send(JSON.stringify(data));
        
        msg.val('');
    });
});