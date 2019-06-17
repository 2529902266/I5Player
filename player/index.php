<?php 
$url = @$_GET['play'];
$url = htmlentities($url,ENT_QUOTES);
?>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name=”applicable-device” content=”pc,mobile”>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/video.js@7.4.1/dist/video-js.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/open-iconic@1.1.1/font/css/open-iconic-bootstrap.min.css">
<link rel="stylesheet" href="../static/style.css">

<title>M3U8播放器</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm rounded nice-nav">
<div class="container">
<a class="navbar-brand logo" href="/"><img src="../static/logo5.png" alt="" class="mr-2">M3U8播放器</a>
</div>
</nav>
<div class="container">
<div class="row">
<div class="col-12 py-3">
<video id="player" class="video-js vjs-16-9 vjs-big-play-centered" controls preload="auto" data-setup="{}">
<source id = "video-player" src="<?php echo $url;?>" type="application/x-mpegURL">
<p class="vjs-no-js">
To view this video please enable JavaScript, and consider upgrading to a web browser that
<a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
</p>
</video>
<div class="input-group my-3">
<input id="video-url" required name="play" type="text" class="form-control nice" placeholder="输入 M3U8 URL 地址" value="<?php echo $url;?>" aria-describedby="button-addon2">
<div class="input-group-append">
<button class="btn btn-dark px-5 play border-0" type="button"><img src="../static/play.png" height="24"></button>
</div>
</div>
<div class="my-3">
<div class="d-none history">
<div class="text-center"><a href="javascript:;" class="p-3 h-close nice-c"><span class="oi oi-chevron-top"></span></a></div>
<ul class="list-unstyled nice-c my-2 h-list">
</ul>
<a href="javascript:;" class="clear-history">清空播放记录</a>
</div>
<div class="text-center"><a href="javascript:;" class="p-3 h-open nice-c"><span class="oi oi-chevron-bottom"></span></span></a></div>
</div>
</div>
</div>
<div class="row nice-c">
<div class="col-md-6 col-12">
<ul class="list-unstyled">
<li><a href="https://i5.gs" target="_blank">博客</a></li>
</ul>
</div>
<div class="col-md-6 col-12">
<h5>M3U8文件格式</h5>
<p><strong>M3U8</strong>文件是指UTF-8编码格式的M3U文件。M3U文件是记录了一个索引纯文本文件，打开它时播放软件并不是播放它，而是根据它的索引找到对应的音视频文件的网络地址进行在线播放。</p>
<p><strong>M3U</strong>是一种播放多媒体列表的文件格式，它的设计初衷是为了播放音频文件，比如MP3，但是越来越多的软件现在用来播放视频文件列表，M3U也可以指定在线流媒体音频源。很多播放器和软件都支持M3U文件格式。</p>
</div>

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/video.js@7.4.1/dist/video.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@videojs/http-streaming@1.10.3/dist/videojs-http-streaming.min.js"></script>
<script src="../static/bundle.js"></script>
<div class="d-none">
</div>
</body>
</html>