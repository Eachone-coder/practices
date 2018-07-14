

$(function () {
    $('#discuss-box').keydown(function(event){
        if (event.keyCode == 13){
            var text = $(this).val();
            var url = "http://swoole.test:8812/?s=index/chart/index";
            var data = {'content': text, 'game_id':1};

            $.post(url, data, function(result){
                $(this).val("");
            }, 'json');
        }
    });
});