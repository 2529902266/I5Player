<?php
/*
 * @Author: yumusb
 * @Date: 2019-07-14 18:39:54
 * @LastEditors: yumusb
 * @LastEditTime: 2019-10-10 16:42:32
 * @Description: 首页文件
 */

require "common.php";

if ($set['autokeywords'] == 1) {
	$word = get_word();
} else {
	$word = "迪迦奥特曼";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title><?php echo $set['title']; ?></title>
	<meta name="keywords" content="<?php echo $set['keywords']; ?>">
	<meta name="description" content="<?php echo $set['desc']; ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="renderer" content="webkit">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<script src="https://cdn.staticfile.org/jquery/2.2.4/jquery.min.js"></script>
	<style>
		* {

			box-sizing: border-box;

		}

		div.search {

			padding: 10px 0;

		}

		.form {

			position: relative;

			width: 300px;

			margin: 0 auto;

		}

		input,
		button {

			border: none;

			outline: none;

		}

		input {

			width: 100%;

			height: 42px;

			padding-left: 13px;

		}

		button {

			height: 42px;

			width: 42px;

			cursor: pointer;

			position: absolute;

		}

		.bar input {

			border: 2px solid #4698c5;

			border-radius: 5px;

			background: transparent;

			top: 0;

			right: 0;

		}

		.bar button {

			background: #4698c5;

			border-radius: 0 5px 5px 0;

			width: 60px;

			top: 0;

			right: 0;


		}

		.bar button:before {

			content: "搜索";

			font-size: 13px;

			color: #F9F0DA;

		}

		.tite {
			padding-top: 15%;
		}

		.tite h1 {
			text-align: center;
			font-size: 24px;
		}

		.list {
			position: absolute;
			top: 40px;
			left: 0;
			width: 300px;
			background-color: #F0F2FF;
			z-index: -2;
			max-height: 400px;
			overflow: auto;
			border: none;
		}

		.list-1::-webkit-scrollbar {
			width: 0px;
			height: 8px;
		}

		/*正常情况下滑块的样式*/

		.list-1::-webkit-scrollbar-thumb {
			background-color: rgba(0, 0, 0, .05);
			border-radius: 10px;
			-webkit-box-shadow: inset 1px 1px 0 rgba(0, 0, 0, .1);
		}

		/*鼠标悬浮在该类指向的控件上时滑块的样式*/

		.list-1:hover::-webkit-scrollbar-thumb {
			background-color: rgba(0, 0, 0, .2);
			border-radius: 10px;
			-webkit-box-shadow: inset 1px 1px 0 rgba(0, 0, 0, .1);
		}

		/*鼠标悬浮在滑块上时滑块的样式*/

		.list-1::-webkit-scrollbar-thumb:hover {
			background-color: rgba(0, 0, 0, .4);
			-webkit-box-shadow: inset 1px 1px 0 rgba(0, 0, 0, .1);
		}

		/*正常时候的主干部分*/

		.list-1::-webkit-scrollbar-track {
			border-radius: 10px;
			-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0);
			background-color: white;
		}

		/*鼠标悬浮在滚动条上的主干部分*/

		.list-1::-webkit-scrollbar-track:hover {
			-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .4);
			background-color: rgba(0, 0, 0, .01);
		}


		.list ul li {
			list-style-type: none;
			line-height: 35px;
		}

		a:link {
			color: black;
			/*未访问的链接颜色*/
		}

		a:visited {
			color: red;
			/*已访问的链接颜色*/
		}

		a:hover {
			color: blue;
			/*鼠标移动到链接的颜色*/
			text-decoration: underline;
		}

		a:active {
			color: orange;
			/*鼠标点击时的颜色*/
		}

		a {
			text-decoration: none;
			/*去掉下划线*/
		}



		.div_foot {

			position: absolute;

			height: 50px;

			text-align: center;
			bottom: 0px;

			line-height: 50px;

			width: 100%;

		}
	</style>
</head>

<body>

	<div class="tite">
		<h1>i5看视频</h1>
	</div>
	<div class="search bar">
		<div class="form">

			<input id="searchMsg" type="text" placeholder="<?php echo $word; ?>">

			<button type="submit" id="btn"></button>

			<div class="list  list-1">
				<ul id="list">

				</ul>
			</div>
			<div style="display:none;" id="load">正在加载...</div>

		</div>


	</div>
	<div class="div_foot"><span>©2019 仅供个人学习交流 | <a href="https://huai.pub/">榆木</a> & <a href="https://owoii.com/">听风</a> | <a href="https://github.com/yumusb/I5Player">源码下载</a> | <a href="http://www.renzhijia.com/">免费空间</a></span>
	</div>

	<script>
		var searchMsg = document.getElementById("searchMsg");
		var list = document.getElementById("list");
		var btn = document.getElementById("btn");
		var load = document.getElementById("load");



		//监听输入框的keuup事件，
		searchMsg.onkeyup = function() {
			if (this.value) {
				show(list);
				// 动态创建script标签，使用百度提供的接口，将查询字符串编码后，写到src当中
				var s = document.createElement('script');
				s.src = 'https://s.video.qq.com/smartbox?callback=fn&plat=2&ver=0&num=5&otype=json&query=' + encodeURI(this.value.trim());
				// 插入到文档后获取jsonp格式的数据，然后调用callback函数，将data数据以参数的形式传入
				document.body.appendChild(s);
			} else {
				hide(list);
			}
		}

		//点击li标签后把输入框的信息填入到文本框
		list.onclick = function(e) {
			var e = e || window.event;
			var target = e.target || e.srcElement;
			if (target.nodeName == "LI") {
				searchMsg.value = target.innerHTML;
				$('#btn').click();
			}
			hide(list)
		}


		//点击百度一下按钮跳转到相应的页面
		$('#btn').click(function() {
			if (($("input[id='searchMsg']").val()) == "") {
				alert("请输入关键字");
			} else {
				show(load);
				$.ajax({
					type: "get",
					url: "./api.php",
					dataType: "json",
					data: "do=get&v=" + $("input[id='searchMsg']").val(),
					async: true,
					success: function(res) {
						if (res.status == 200) {
							res = res.res;
							lihtml = "";
							$.each(res, function(index, value) {

								lihtml = lihtml + '<li><a href=javascript:play(' + value["url"] + ',"' + value["title"] + '")>' + value["title"] + '</a></li>';
							});

							$("ul").html(lihtml);
							hide(load);
							show(list);
						} else {
							alert(res.res);
						}

					},
					error: function(a) {
						alert("失败,请检查关键字。");
					}
				});
			}

		});

		function play(id, title) {
			show(load);
			$.ajax({
				type: "get",
				url: "./api.php",
				dataType: "json",
				data: "do=play&v=" + id + "&title=" + title,
				async: true,
				success: function(res) {
					if (res.status == 200) {
						res = res.res;
						lihtml = "";
						$.each(res, function(index, value) {

							lihtml = lihtml + '<li><a target="_blank" href="' + value['url'] + '">' + value['title'] + '</a></li>';
							$("ul").html(lihtml);
							hide(load);
							show(list);
						});
					} else {
						alert(res.res);
					}
				},
				error: function(a) {
					alert("失败，请检查关键字。");
				}
			})
		}

		function fn(data) {
			var lihtml = "";
			//这时候遍历查询到的信息，放到li标签当中
			data.item.forEach(function(item, index) {
				lihtml = lihtml + '<li>' + item['word'] + '</li>';
			});
			$("ul").html(lihtml);
			show(list);

			// 获取到数据后，把脚本删除
			var s = document.querySelectorAll('script');
			for (var i = 1, len = s.length; i < len; i++) {
				document.body.removeChild(s[i]);
			}
		}

		function hide(obj) {
			obj.style.display = "none"
		}

		function show(obj) {
			obj.style.display = "block"
		}
	</script>

</body>


</html>