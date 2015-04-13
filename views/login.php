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
    <a href="<?php echo BASE_URL . '?f=user_center';?>" class="back"><i class="icon-left-open-big"></i></a>
    <span>登录 / 注册</span>
</header>
<section class="login-container">
    <div class="main">
        <form method="post" action="">
            <div class="item">
                <div class="item-field">
                    <i class="icon-user"></i>
                    <input type="text" placeholder="用户名 / 邮箱 / 手机" name="username" id="username">
                </div>
            </div>
            <div class="item">
                <div class="item-field">
                    <i class="icon-lock-alt"></i>
                    <input type="password" name="password" id="password">
                </div>
            </div>
        </form>
    </div>
</section>
<section class="btn-group">
    <button class="full-btn login" data-url="<?php echo BASE_URL . '?f=login';?>">登录</button>
    <button class="full-btn register" data-url="<?php echo BASE_URL . '?f=register';?>">注册</button>
</section>
<script src="http://cdn.staticfile.org/zepto/1.0rc1/zepto.min.js"></script>
<script src="./static/js/core.js"></script>
<script>
(function() {
    var $username = $('#username');
    var $password = $('#password');

    $('.btn-group').on('touchstart', function(e) {
        var name = $username.val();
        var pwd = $password.val();
        var target = $(e.target);

        if (!$.trim(name) || !$.trim(pwd)) {
            return false;
        }

        var result = EXE.collect($('.main'));
        var url = target.data('url');

        var xhr = $.ajax({
            url: url,
            type: 'POST',
            data: {data: JSON.stringify(result)},
            success: function(msg) {
                if (msg === "success") {
                    window.location.href = '<?php echo BASE_URL;?>';
                }
            },
            error: function() {
                xhr = null;
            },
            always: function() {
                xhr = null;
            }
        });
    });
})();
</script>
</body>
</html>
