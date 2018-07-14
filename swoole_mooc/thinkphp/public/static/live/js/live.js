var wsUrl = "ws://swoole.test:8811";

var websocket = new WebSocket(wsUrl);

websocket.onopen = function (evt) {
    console.log('connected-swoole-success');
}

websocket.onmessage = function (evt) {
    push(evt.data);
    console.log('ws-server-return-data:' + evt.data);
}

websocket.onclose = function (evt) {
    console.log('close');
}

websocket.onerror = function (evt, e) {
    console.log('error:' + evt.data);
}

function push(data) {
    data = JSON.parse(data);

    html = '<div class="frame">';
    html +=     '<h3 class="frame-header">';
    html +=         '<i class="icon iconfont icon-shijian"></i>第'+data.type+'节 01：30';
    html +=     '</h3>';
    html +=     '<div class="frame-item">';
    html +=         '<span class="frame-dot"></span>';
    html +=         '<div class="frame-item-author">';
    html +=             '<img src="'+data.logo +'" width="20px" height="20px" /> ' + data.title;
    html +=         '</div>';
    html +=         '<p>'+data.content+'</p>';
    html +=     '</div>';
    html += '</div>';

    $('#match-result').prepend(html);
}