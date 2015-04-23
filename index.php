<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="shortcut icon" href="favicon.ico" /> 
		<title>任务板 - TaskBoard</title>
	</head>
	<script type="text/javascript" src="jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="cookie.js"></script>
	<style type="text/css">
		body {
			-moz-user-select:none;
			-webkit-user-select:none;
			background-color: rgba(67,161,2,0.8);
			color: white;
		}
		#friendDiv {
			width: 10%;
			min-width: 200px;
			height: auto;
			border-radius: 20px;
			border: 3px dashed;
			text-align: center;
			padding-bottom: 15px;
		}
		#UpdateDiv {
			width: 10%;
			min-width: 320px;
			height: auto;
			border-radius: 20px;
			border: 3px dashed;
			text-align: center;
			padding-bottom: 15px;
		}
		#taskDiv {
			width: 10%;
			min-width: 320px;
			height: auto;
			border-radius: 20px;
			border: 3px dashed;
			text-align: center;
			padding-bottom: 15px;
		}
		#LibraryDiv {
			width: 10%;
			min-width: 320px;
			height: auto;
			border-radius: 20px;
			border: 3px dashed;
			text-align: center;
			padding-bottom: 15px;
		}
		p.headerP {
			font-size: 20px;
			font-weight: bold;
			text-decoration: underline;
		}
		.model {
			display: none;
			margin: 5px auto;
		}
		.model a {
			background-color: rgba(67,161,2,1);
			display: block;
			cursor: pointer;
			border: 1px solid;
			padding: 5px;
			margin: 5 15px;
		}
		#navigationDiv {
			text-align: center;
			width: 320px;
			height: 50px;
			margin: 15px auto;
			padding: 0;
		}
		#navigationDiv ul {
			list-style-type: none;
			padding: 0;
		}
		#navigationDiv ul .selected {
			background-color: white;
			color: rgba(67,161,2,1);
			border: 1px solid white;
		}
		#navigationDiv li {
			background-color: rgba(67,161,2,1);
			padding: 5px;
			cursor: pointer;
			border: 1px solid;
			margin: 15px 0;
			width: 67px;
			float: left;
			display: inline;
		}
		#operationDiv {
			width: 100px;
			text-align: center;
			margin: 15px auto;
		}
		#operationDiv span {
			background-color: rgba(67,161,2,1);
			cursor: pointer;
			font-size: 50px;
			width: 50px;
			height: 50px;
			border-radius: 50px;
			padding: 1 15px;
			border: 2px solid white;
		}
		a.state1 {
			background-color: #4499EE;
		}
		a.state2 {
			background-color: #EED205;
		}
		a.state3 {
			background-color: #FF6600;
		}
		a.state4 {
			background-color: #4C4C4C;
		}
		a.state5 {
			background-color: #000000;
		}
	</style>
	<body>
		<div id="navigationDiv">
			<ul>
				<li class="tabBtn" id="FriendDivBtn">Friend</li>
				<li class="tabBtn" id="UpdateDivBtn">Update</li>
				<li class="tabBtn" id="LibraryDivBtn">Library</li>
				<li class="tabBtn selected" id="TaskDivBtn">Task</li>
			</ul>
		</div>
		<div id="operationDiv">
			<span id="plusBtn">&plus;</span>
		</div>

		<?php
			function remainTime($t) {
				$r = $t - time();
				if ($r < 0) {
					return "-" . remainTime($t-2*$r);
				} else if ($r < 60 * 60) {
					return intval($r/60) . "分钟";
				} else if ($r < 60 * 60 * 24) {
					return intval($r/(60*60)) . "小时";
				} else {
					return intval($r/(60*60*24)) . "天";
				}
			}
			$con = mysqli_connect("localhost", "root", "", "taskboard");
			if (!$con) {
				die('Could not connect: ' . mysqli_error());
			}
			mysqli_query($con, "SET NAMES UTF8");
		?>

		<div id="FriendDiv" class="Model">
			<p class="headerP">朋友</p>
			<a>刘超</a>
			<a>谢贤忱</a>
		</div>
		<div id="PlusFriendDiv" class="Model">
			
		</div>
		<div id="TaskDiv" class="Model">
			<p class="headerP">任务板</p>
			<?php
				$result = mysqli_query($con, 'SELECT * FROM task');
				if ($result) {
					while($row = mysqli_fetch_array($result)) {
						$deadline = $row['deadline'];
						if ($deadline == 0) {
							echo '<a class="state4 TaskEntry">' . $row['entry'] . '<br><code>长期</code></a>';
						} else {
							if ($deadline - time() < 0) {
								echo '<a class="state5 TaskEntry">' . $row['entry'] . '<br><code>' . remainTime($row['deadline']) . '</code></a>';
							} else {
								if ($r < 60 * 60 * 24) {
									echo '<a class="state3 TaskEntry">' . $row['entry'] . '<br><code>' . remainTime($row['deadline']) . '</code></a>';
								} else if ($r < 60 * 60 * 24 * 3) {
									echo '<a class="state2 TaskEntry">' . $row['entry'] . '<br><code>' . remainTime($row['deadline']) . '</code></a>';
								} else {
									echo '<a class="state1 TaskEntry">' . $row['entry'] . '<br><code>' . remainTime($row['deadline']) . '</code></a>';
								}
							}
						}
					}
				}
			?>
			<a class="state2 TaskEntry">SAP大作业<br><code>3天</code></a>
			<a class="state3 TaskEntry">组会log<br><code>0天</code></a>
			<a class="state1 TaskEntry">颗粒朋友圈<br><code>长期</code></a>
			<a class="state4 TaskEntry">GetWash网站<br><code>长期</code></a>
			<a class="state1 TaskEntry">密码学作业<br><code>5天</code></a>
			<a class="state1 TaskEntry">电影推荐系统<br><code>10天</code></a>
			<a class="state3 TaskEntry">智能车竞赛<br><code>10天</code></a>
			<a class="state5 TaskEntry">可计算<br><code>-2天</code></a>
		</div>
		<div id="LibraryDiv" class="Model">
			<p class="headerP">公共库</p>
			<?php
				$result = mysqli_query($con, 'SELECT * FROM library');
				if ($result) {
					while($row = mysqli_fetch_array($result)) {
						$deadline = $row['deadline'];
						if ($deadline == 0) {
							echo '<a class="state4 LibraryEntry">' . $row['entry'] . '<br><code>长期</code></a>';
						} else {
							echo remainTime($row['deadline']);
							if ($deadline - time() < 0) {
								echo '<a class="state5 LibraryEntry">' . $row['entry'] . '<br><code>' . remainTime($row['deadline']) . '</code></a>';
							} else {
								if ($r < 60 * 60 * 24) {
									echo '<a class="state3 LibraryEntry">' . $row['entry'] . '<br><code>' . remainTime($row['deadline']) . '</code></a>';
								} else if ($r < 60 * 60 * 24 * 3) {
									echo '<a class="state2 LibraryEntry">' . $row['entry'] . '<br><code>' . remainTime($row['deadline']) . '</code></a>';
								} else {
									echo '<a class="state1 LibraryEntry">' . $row['entry'] . '<br><code>' . remainTime($row['deadline']) . '</code></a>';
								}
							}
						}
					}
				}
			?>
			<a class="state2 LibraryEntry">SAP大作业<br><code>3天</code></a>
			<a class="state3 LibraryEntry">组会log<br><code>0天</code></a>
			<a class="state1 LibraryEntry">颗粒朋友圈<br><code>长期</code></a>
			<a class="state4 LibraryEntry">GetWash网站<br><code>长期</code></a>
			<a class="state1 LibraryEntry">密码学作业<br><code>5天</code></a>
			<a class="state1 LibraryEntry">电影推荐系统<br><code>10天</code></a>
			<a class="state3 LibraryEntry">智能车竞赛<br><code>10天</code></a>
		</div>
		<div id="UpdateDiv" class="Model">
			<p class="headerP">动态</p>
			<a><code>刘超</code><br><code>1天前</code><br><code>:</code><br>“SAP大作业真是太蛋疼了！”</a>
			<a><code>刘超</code><br><code>1天前</code><br><code>-</code><br>SAP大作业</a>
			<a><code>刘超</code><br><code>1天前</code><br><code>+</code><br>SAP大作业</a>
		</div>
		<div id="LoginDiv" class="Model">
			<p class="headerP">登录</p>

		</div>
		<div id="SignUpDiv" class="Model">
			<p class="headerP">注册</p>

		</div>
	</body>
	<script type="text/javascript">
		$(document).ready(function () {
			// var user = $.cookie("user");
			// alert(user);
			// if (user == null) {
			// 	$.cookie("user", "lhzbxx", { expires: 7 });
			// } else {
			// 	$("#navigationDiv").data('current', '#TaskDiv');
			// 	$('#TaskDiv').slideToggle(200);
			// }
			$("#navigationDiv").data('current', '#TaskDiv');
			$('#TaskDiv').slideToggle(200);
			$(".tabBtn").click(function() {
				var curr = $("#navigationDiv").data('current');
				var next = "#"+$(this).text()+"Div";
				if (curr == next) {
					return;
				};
				$(curr+"Btn").toggleClass('selected');
				$(next+"Btn").toggleClass('selected');
				$(curr).slideToggle(200, function(){$(next).slideToggle(200)});
				$("#navigationDiv").data('current', next);
			});
			$("#plusBtn").click(function() {
				var curr = $("#navigationDiv").data('current');
				if (curr == "#TaskDiv") {

				} else if (curr == "#UpdateDiv") {

				} else if (curr == "#LibraryDiv") {

				} else if (curr == "#FriendDiv") {

				} else {
					return;
				}
			});
			$(".TaskEntry").dblclick(function() {
				
			});
			$(".LibraryEntry").dblclick(function() {
				
			});
		});
	</script>
</html>