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
    <a href="<?php echo BASE_URL;?>" class="back"><i class="icon-left-open-big"></i></a>
    <span>个人中心</span>
</header>
<section class="bg">
    <a href="javascript:void(0);" class="camera">
        <i class="icon-camera"></i>
    </a>
</section>
<section class="user-container">
    <?php if ($userInfo['isLogin']) {
    ?>
    <div class="list">
        <div class="item">
            <span class="label-icon">
                <i class="icon-user"></i>
            </span>
            <input type="text" value="<?php echo $userInfo['username'];?>" disabled="disabled">
        </div>
        <div class="item">
            <span class="label-icon">
                <i class="icon-mobile"></i>
            </span>
            <input type="text" value="<?php echo $userInfo['phone'];?>">
        </div>
        <div class="item">
            <span class="label-icon">
                <i class="icon-mail-1"></i>
            </span>
            <input type="text" value="<?php echo $userInfo['email'];?>">
        </div>
        <div class="item">
            <span class="label-icon">
                <i class="icon-up-open-mini"></i>
            </span>
            <select id="" name="">
                <option value="男">男</option>
                <option value="女">女</option>
            </select>
        </div>
    </div>
    <?php } else {?>
    <div class="no-login">
        <a href="<?php echo BASE_URL . "?f=user_login"?>">你还没有登录</a>
    </div>
    <?php }?>
</section>
<script src="http://cdn.staticfile.org/zepto/1.0rc1/zepto.min.js"></script>
</body>
</html>
