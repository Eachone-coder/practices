
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/css/index.css">
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <link rel="icon" href="http://zhaojiaxing.top/wp-content/uploads/2017/06/cropped-_20170502135922-32x32.jpg" sizes="32x32" />
	<link rel="icon" href="http://zhaojiaxing.top/wp-content/uploads/2017/06/cropped-_20170502135922-192x192.jpg" sizes="192x192" />
    <title>TODO</title>
</head>
<body>
    <section class="todoapp">
        <header class="header">
            <h1>todos</h1>
            <input class="new-todo" placeholder="What needs to be done?">
        </header>
        <section class="main">
        <?php if (!empty($list)) { ?>

                <input class="toggle-all" type="checkbox" disabled>
            <?php foreach($list as $todo) { ?>
                <ul class="todo-list">
                    <?php if ($todo['status'] == 1) { ?>
                        <li class="todo">
                    <?php } elseif ($todo['status'] == 2) { ?>
                        <li class="completed">
                    <?php } ?>
                        <div class="view">
                            <input class="toggle"
                                   type="checkbox"
                                   data-id="<?php echo $todo['id'] ?>"
                                   data-status="<?php echo $todo['status'] ?>"
                                   <?php if ($todo['status'] == 2) { ?>checked=true<?php } ?>
                            >
                            <label><?php echo $todo['content'] ?></label>
                            <button class="destroy" data-id="<?php echo $todo['id'] ?>"></button>
                        </div>
                        <input class="edit" type="text">
                    </li>
                </ul>
            <?php } ?>

        <?php } ?>
        </section>
        <footer class="footer" v-show="todos.length" v-cloak>
            <span class="todo-count">
                <strong> <?php echo count($list); ?> </strong>
            </span>
            <ul class="filters">
                <li><a class="selected ajax-todo" data-status = 'all'>All</a></li>
                <li><a class="ajax-todo" data-status = 'active'>Active</a></li>
                <li><a class="ajax-todo" data-status = 'completed'>Completed</a></li>
            </ul>
            <!-- <button class="clear-completed">
                Clear completed
            </button> -->
        </footer>
    </section>
    <footer class="info">
        <p>zjx</p>
    </footer>

    <script>
    // 添加
    $('.new-todo').keydown(function(e){
        var _this = $(this);
        if(e.keyCode==13){
            var content = $(this).val();
            $.post(
                '/index/addTodo',
                {content:content},
                function(data){
                    if(data.status == 1){
                        todoAppend(data.info);
                        incCount();
                        _this.val('');
                    }
                }
            );
        }
    });
    // 删除
    $('.main').on('click', '.destroy', function(){
        var id = $(this).data('id');
        var _this = $(this);
        $.post(
            '/index/delTodo',
            {id:id},
            function(data){
                if(data.status == 1){
                    todoRemove(_this);
                    decCount();
                }
            }
        );
    });
    // 更改状态
    $('.main').on('change', '.toggle', function(){
        var id = $(this).data('id');
        var status = $(this).data('status');
        var _this = $(this);
        $.post(
            '/index/changeTodoStatus',
            {id:id, status:status},
            function(data){
                if(data.status == 1){
                    if(status == 1){
                        _this.parents('li').removeClass('todo');
                        _this.parents('li').addClass('completed');
                        _this.data('status', 2);
                        decCount();
                    }else{
                        _this.parents('li').addClass('todo');
                        _this.parents('li').removeClass('completed');
                        _this.data('status', 1);
                        incCount();
                    }

                }
            }
        );
    });
    $('.ajax-todo').click(function(){
        var status = $(this).data('status');
        $('.ajax-todo').removeClass('selected');
        $(this).addClass('selected');
        $.post(
            '/index/ajaxTodo',
            {status:status},
            function(data){
                if(data.status == 1){
                    var info = data.info;
                    var count = 0;
                    $('.main').html(' ');
                    $.each(info, function(index){
                        todoAppend(info[index]);
                        count++;
                    });
                    setCount(count);
                }
            }
        );
    })
    /**
     * 删除数据
     * @auther zjx
     * @date   2017-12-06
     * @param  object     todo 操作的按钮
     * @return void
     */
    function todoRemove(todo) {
        todo.parent().parent().remove();
    }
    /**
     * 追加数据
     * @auther zjx
     * @date   2017-12-06
     * @param  json     data
     * @return void
     */
    function todoAppend(data){
        var li_class = 'todo';
        var input_check = '';
        if(parseInt(data.status) == 2){
            li_class = 'completed';
        }
        var html = '';
        html += '<ul class="todo-list">';
        html +=     '<li class="'+li_class+'">';
        html +=         '<div class="view">';
        if(parseInt(data.status) == 2){
            html +=             '<input class="toggle" type="checkbox" checked data-status="'+data.status+'" data-id="' + data.id + '">';
        }else{
            html +=             '<input class="toggle" type="checkbox" data-status="'+data.status+'" data-id="' + data.id + '">';
        }
        html +=             '<label>'+data.content+'</label>';
        html +=             '<button class="destroy" data-id="' + data.id + '"></button>';
        html +=         '</div>';
        html +=         '<input class="edit" type="text">';
        html +=     '</li>';
        html += '</ul>';
        $('.main').append(html);
    }
    function setCount(count) {
        $('.todo-count').find('strong').html(count);
    }

    function decCount() {
        var count = parseInt($('.todo-count').find('strong').html());
        if(count <= 0){
            return;
        }
        $('.todo-count').find('strong').html(count-1);
    }
    function incCount() {
        var count = parseInt($('.todo-count').find('strong').html());
        $('.todo-count').find('strong').html(count+1);
    }
    </script>

</body>
</html>
