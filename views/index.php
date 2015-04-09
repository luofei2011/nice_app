<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EXE</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0;maximum-scale=1.0;user-scalable=no;">
    <meta http-equiv="X-UA-Compatibel" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="./static/css/reset.css">
    <link rel="stylesheet" href="./static/css/fontello.css">
    <link rel="stylesheet" href="./static/css/animation.css">
    <link rel="stylesheet" href="./static/css/index.css">
</head>
<body>
<header id="header">
    <a href="<?php echo BASE_URL . "?f=user_center"?>" class="position"><i class="icon-user"></i></a>
    <span><?php if ($userInfo['isLogin']) { ?>添加记录<?php } else { ?>点击头像登录<?php } ?></span>
</header>
<div id="wrapper">
    <button class="btn btn-txt" id="addItem">添加<i class="icon-plus"></i></button>
    <div class="list">
        <div class="item">
            <label for="">游泳</label>
            <input type="number">
            <span class="unit">米</span>
            <a href="javascript:void(0);">
                <i class="icon-pencil"></i>
            </a>
        </div>
        <div class="item">
            <label for="">跑步</label>
            <input type="number">
            <span class="unit">公里</span>
            <a href="javascript:void(0);">
                <i class="icon-pencil"></i>
            </a>
        </div>
        <div class="item">
            <label for="">俯卧撑</label>
            <input type="number">
            <span class="unit">组</span>
            <a href="javascript:void(0);">
                <i class="icon-pencil"></i>
            </a>
        </div>
        <div class="item">
            <label for="">仰卧起坐</label>
            <input type="number">
            <span class="unit">个</span>
            <a href="javascript:void(0);">
                <i class="icon-pencil"></i>
            </a>
        </div>
    </div>
</div>
<div class="btn-group clearfix">
    <button class="full-btn store">存储</button>
    <button class="full-btn query">查询</button>
</div>
<div class="history"></div>
<div id="cover">
    <div class="add-item">
        <h2 class="add-title">添加项目</h2>
        <div class="list">
            <div class="item">
                <span class="label">Name</span>
                <input type="text" class="input" name="itemName" id="itemName">
            </div>
            <div class="item">
                <span class="label">Unit</span>
                <select id="" class="input" name="itemUnit">
                    <option value="个">个</option>
                    <option value="次">次</option>
                    <option value="米">米</option>
                    <option value="组">组</option>
                    <option value="小时">小时</option>
                    <option value="公里">公里</option>
                </select>
            </div>
            <div class="item">
                <span class="label">Cycle</span>
                <select id="" class="input" name="itemFrequency">
                    <option value="每天">每天</option>
                    <option value="每周">每周</option>
                    <option value="每月">每月</option>
                    <option value="每年">每年</option>
                </select>
            </div>
            <div class="deal-btn clearfix">
                <a href="javascript:void(0);" class="remove">REMOVE</a>
                <a href="javascript:void(0);" class="save">DONE</a>
                <a href="javascript:void(0);" class="cancel">CANCEL</a>
            </div>
        </div>
    </div>
</div>
<script src="./static/js/esl.js"></script>
<script src="http://cdn.staticfile.org/zepto/1.0rc1/zepto.min.js"></script>
<script src="./static/js/core.js"></script>
<script>
EXE.base_url = '<?php echo BASE_URL;?>';
EXE.isLogin = <?php echo json_encode($userInfo['isLogin'])?>;
</script>
<script src="./static/build/item_list.js"></script>
<script>
(function() {
    /*
    var timer = null;
    $('#wrapper input[type=number]').on('focus', function() {
        var $self = $(this);
        timer = setTimeout(function() {
            var v = $self.val();
            if (isNaN(v)) {
                $self.addClass('error');
            } else {
                $self.removeClass('error');
            }

            timer = setTimeout(arguments.callee, 100);
        }, 100);
    }).on('blur', function() {
        window.clearTimeout(timer);
    });
    */

    // 初始化覆盖层 
    var $cover = $('#cover');
    var $addItem = $('.add-item');

    $addItem.on('touchstart', function(e) {
        e.cancelBubble = true;
    });

    $cover.on('touchstart', function() {
        resetForm($addItem);
        $addItem.find('.deal-btn a').removeAttr('data-id');
        $(this).hide();
    });

    var $win = $(window);
    function initCover() {
        var win_width = $win.width();
        var win_height = $win.height();

        $cover.width(win_width);
        $cover.height(win_height);
        $cover.show();
    }

    $cover.width($win.width()).height($win.height());

    $win.on('resize', initCover);

    // 处理新加按钮事件
    $('.deal-btn').on('touchstart', function(e) {
        var target = e.target;
        var $this = $(target);
        if ($this.hasClass('save')) {
            var name = $('#itemName').val();

            var result = EXE.collect($addItem);
            var url = EXE.base_url + '?f=addItem';
            if ($this.hasClass('edit')) {
                url = EXE.base_url + '?f=edit_item';
                result.id = parseInt($this.data('id'));
            }
            if ($.trim(name)) {
                var xhr = $.ajax({
                    url: url,
                    type: 'post',
                    data: {data: result},
                    success: function() {
                        EXE.midWare.emit('update');
                        $cover.trigger('touchstart');
                    }
                });
            }
        } else if ($this.hasClass('cancel')) {
            $cover.trigger('touchstart');
        } else if ($this.hasClass('remove')) {
            var id = $this.data('id') - 0;
            $.ajax({
                url: EXE.base_url + '?f=remove_line',
                type: 'post',
                data: {data: id},
                success: function() {
                    EXE.midWare.emit('update');
                    $cover.trigger('touchstart');
                }
            });
        }
        return false;
    });

    function resetForm(node) {
        var items = node.find('input,select');
        items.each(function() {
            if (this.nodeName.toLowerCase() === 'input') {
                this.value = "";
            } else {
                $(this).find('option').get(0).selected = true;
            }
        });
    }

    $('#addItem').on('touchstart', function() {
        $cover.show();
    });

    // 编辑事件
    //$('#wrapper').on('click', function(e) {
    $(document).on('touchstart', '.icon-pencil', function() {
        var result = [];
        var $parent = $(this).closest('.item');
        var id = $parent.data('id');

        result.push($parent.find('label').eq(0).text());
        result.push($parent.find('.unit').text());
        result.push($parent.find('input[type=hidden]').val());

        $addItem.find('input,select').each(function(idx, item) {
            if (this.nodeName.toLowerCase() === 'input') {
                this.value = result[idx];
            } else {
                $(this).find('option').each(function() {
                    if (this.value === result[idx]) {
                        this.selected = true;
                        return false;
                    }
                });
            }
        });
        $addItem.find('a').attr('data-id', id).addClass('edit');

        $cover.show();
    });

    // 查询事件
    $('.query').on('touchstart', function() {
        $.ajax({
            url: EXE.base_url + '?f=query_run',
            type: 'post',
            data: {data:''},
            success: function(data) {
                try {
                    data = JSON.parse(data);
                } catch(e) {
                    data = [];
                }
                if (data.toString() === '[object Object]') {
                    data = [data];
                }

                var html = "";
                for (var i = 0, len = data.length; i < len; i++) {
                    html += '<p>' + data[i].time + ' ' + data[i].content + '</p>';
                }

                $('.history').html(html);
            },
            error: function() {
            },
            always: function() {
            }
        });
    });

    // 存储事件
    $('.store').on('touchstart', function() {
        var arr = [];
        $('#wrapper .item').each(function() {
            var $this = $(this);
            var name = $this.find('label').text();
            var r = $this.find('input[type=number]').val();

            arr.push(name + "【" + r  + "】" + $this.find('.unit').text());
        });

        $.ajax({
            url: EXE.base_url + '?f=save_run',
            type: 'post',
            data: {data: arr},
            success: function() {
                resetForm($('#wrapper .list'));
            }
        });
    });
})();
</script>
</body>
</html>
