var wsUrl = "ws://swoole.test:8812";

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

    html  = '<div class="comment">';
    html +=    '<span>'+data.user+'</span>';
    html +=    '<span>'+data.content+'</span>';
    html += '</div>';

    $('#comments').append(html);
}