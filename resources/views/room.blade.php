<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>WebSocket测试工具</title>
	<style type="text/css">
		* {
            margin: 0;
            padding: 0;
        }

        .main {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1
        }

        .content {
            width: 60%;
            margin: 20px auto 0;
            border: 1px solid #495057;
            border-radius: 10px;
            min-width: 800px;
        }

        .text {
            width: 65%;
            height: 40px;
            line-height: 38px;
            font-size: 20px;
            text-indent: 10px;
        }

        .button {
            width: 10%;
            height: 42px;
            line-height: 38px;
            font-size: 20px;
        }

        #connect-div {
            padding: 10px;
        }

        #msg-div {
            height: 500px;
            border-top: 1px solid #495057;
            border-bottom: 1px solid #495057;
            padding: 10px;
            overflow-y: auto;
        / / 关键
        }

        #send-div {
            padding: 10px;
        }

        .clear-button {
            width: 20%;
        }

        .client {
            color: green;
        }

        .server {
            color: blue;
        }

        .connect {
            color: red;
        }

        .msg {
            color: black;
        }

        #hideId {
            position: absolute;
            width: 100px;
        }

        #connectId {
            color: green;
            background-color: white;
        }

        #closeId {
            color: red;
            background-color: white;
        }

        #showId {
            color: blue;
            background-color: white;
        }

        #sendId {
            color: white;
            background-color: #0D95F0;
        }

        #clearId {
            color: white;
            background-color: #5A6267;
        }
	</style>
</head>
<body>
	<div class="main">
		<div id="context-div" class="content">
			<div id="connect-div">
				<input id="urlId" class="text" type="hidden" value="ws://39.103.235.147:2346" required="true" placeholder="请输入websocket地址">
				<button id="connectId" class="button" type="button" onclick="connectWebSocket()">连接</button>
				<button id="closeId" class="button" type="button" onclick="closeWebSocket()">断开</button>
				<button id="showId" class="button" type="button" onclick="fullScreen()">全屏</button>
				<input type="text" id="name" class="text" name="name" value="" placeholder="请输入昵称" readonly>
			</div>
			<div id="msg-div"></div>
			<div id="send-div">
				<input id="msgId" class="text msg-text" type="text" required="true" placeholder="请输入发送消息">
				<button id="sendId" class="button" type="button" onclick="sendMessage()">发送</button>
				<button id="clearId" class="button clear-button" type="button" onclick="clearMessage()">清理消息</button>
			<div>
		<div>
	</div>

	<script type="text/javascript">

		var firstname = ["李", "朱", "西门", "沈", "张", "上官", "司徒", "欧阳", "轩辕", "赵"];
        var nameq = ["彪", "巨昆", "金虎", "锐", "翠花", "小小", "撒撒", "熊大", "宝强"];
        var xingxing = firstname[Math.floor(Math.random() * (firstname.length))];
        var mingming = nameq[Math.floor(Math.random() * (nameq.length))];
        let name = xingxing + mingming;
        document.getElementById('name').value = name

        var ws = null;
        var client_id = ""

        // 连接WebSocket
        function connectWebSocket() {
            if (ws == null || ws.readyState != WebSocket.OPEN) {
                if (window.WebSocket) {
                    var wsPath = document.getElementById('urlId').value;
                    if (wsPath != null && wsPath != '') {
                        ws = new WebSocket(wsPath);
                        ws.onopen = function (event) {
                            console.log("websocket连接成功..." + wsPath);
                            creatdiv("WebSocket 连接成功", "");
                            ws.send(JSON.stringify({
                                type: 'login',
                                client_name: name,
                                room_id: 1,
                            }));
                        };

                        ws.onmessage = function (event) {
                            console.log("websocket接收数据：" + event.data);
                            data = JSON.parse(event.data);
                            if (data.type == 'connect') {
                                client_id = data.client_id;
                            } else if (data.type == "login") {
                                creatdiv(data.client_name + " 进入房间", '系统消息通知 ');
                            } else if (data.type == 'room_say') {
                                creatdiv(data.content + " ", data.client_name);

                            } else if (data.type == "logout") {
                                creatdiv(data.from_client_name + " 离开", '系统消息通知 ');
                            }

                            //creatdiv(event.data, "服务端 ");
                        };
                        ws.onclose = function (event) {
                            console.log("websocket关闭..." + wsPath);
                            creatdiv("WebSocket 关闭", "");
                        };
                        ws.onerror = function (event) {
                            console.log("websocket异常..." + wsPath);
                            creatdiv("WebSocket 异常", "");
                        };
                    } else {
                        alert("请输入正确的websocket地址");
                    }
                } else {
                    alert("您的浏览器不支持WebSocket协议！");
                }

            } else {
                creatdiv("WebSocket 已连接", "");
            }
        }

        //关闭WebSocket连接
        function closeWebSocket() {
            if (ws != null && ws.readyState == WebSocket.OPEN) {
                ws.close();
            } else {
                console.log("websocket已断开...");
                creatdiv("WebSocket 已断开", "");
            }
        }

        //发送消息
        function sendMessage() {
            var msg = document.getElementById('msgId').value;
            if (ws != null && ws.readyState == WebSocket.OPEN) {

                if (msg != "") {
                    ws.send(JSON.stringify({
                        type: 'room_say',
                        client_name: name,
                        room_id: 1,
                        content: msg
                    }));
                    document.getElementById('msgId').value = ""
                }

            } else {
                creatdiv("WebSocket 已断开", "");
            }
        }

        function sendMessageAll() {
            var name = document.getElementById('name').value;
            if (name === null || name === "") {
                alert("请输入昵称")
                return false;
            }
            if (ws != null && ws.readyState == WebSocket.OPEN) {
                var msg = document.getElementById('msgId').value;
                creatdiv(msg, document.getElementById('name').value + " ");
                ws.send(JSON.stringify({
                    type: 'say',
                    name: name,
                    content: msg,
                    to_client_id: 'all'
                }));
            } else {
                creatdiv("WebSocket 已断开", "");
            }
        }

        // 清空消息
        function clearMessage() {
            var msgDiv = document.getElementById('msg-div');
            // 获取 div 标签下的所有子节点
            var pObjs = msgDiv.childNodes;
            for (var i = pObjs.length - 1; i >= 0; i--) { // 一定要倒序，正序是删不干净的，可自行尝试
                msgDiv.removeChild(pObjs[i]);
            }
        }

        // 加载时连接websocket
        window.onload = connectWebSocket;

        //监听窗口关闭事件，当窗口关闭时，主动去关闭websocket连接，防止连接还没断开就关闭窗口，server端会抛异常。
        window.onbeforeunload = function () {
            closeWebSocket();
        }

        // 按键处理
        window.onkeypress = function (e) {
            e = e || window.event || arguments.callee.caller.arguments[0];
            if (e && (e.keyCode == 122 || e.keyCode == 27)) {
                fullScreen(e);
                //e.preventDefault();
                // e.stopPropagation();
            }
        }

        // 全屏处理
        function fullScreen() {
            var el = document.documentElement;
            var isFullscreen = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen;
            if (!isFullscreen) {//进入全屏,多重短路表达式
                (el.requestFullscreen && el.requestFullscreen()) ||
                (el.mozRequestFullScreen && el.mozRequestFullScreen()) ||
                (el.webkitRequestFullscreen && el.webkitRequestFullscreen()) ||
                (el.msRequestFullscreen && el.msRequestFullscreen());
                document.getElementById("showId").innerHTML = "退出全屏";
            } else {	//退出全屏,三目运算符
                document.exitFullscreen ? document.exitFullscreen() :
                    document.mozCancelFullScreen ? document.mozCancelFullScreen() :
                        document.webkitExitFullscreen ? document.webkitExitFullscreen() : '';
                document.getElementById("showId").innerHTML = "全屏";
            }
        }

        //创建一个div
        function creatdiv(msg, user) {
            var msgDiv = document.getElementById('msg-div');
            var userDiv = document.createElement('div');
            var sendDiv = document.createElement('div');
            var br = document.createElement("br");
            userDiv.appendChild(br);
            var now = new Date().Format("hh:mm:ss");
            userDiv.innerHTML = user + now;
            if (user == document.getElementById('name').value + " ") {
                userDiv.className = "client";
                sendDiv.className = "msg";
            } else if (user == "服务端 ") {
                userDiv.className = "server";
                sendDiv.className = "msg";
            } else {
                userDiv.className = "msg";
                sendDiv.className = "connect";
            }
            sendDiv.innerHTML = msg;
            userDiv.appendChild(sendDiv);
            userDiv.appendChild(br);
            msgDiv.appendChild(userDiv);
            userDiv.scrollTop = userDiv.scrollHeight;
        }

        Date.prototype.Format = function (fmt) {
            var o = {
                "M+": this.getMonth() + 1, // 月份
                "d+": this.getDate(), // 日
                "h+": this.getHours(), // 小时
                "m+": this.getMinutes(), // 分
                "s+": this.getSeconds(), // 秒
                "q+": Math.floor((this.getMonth() + 3) / 3), // 季度
                "S": this.getMilliseconds() // 毫秒
            };
            if (/(y+)/.test(fmt))
                fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
            for (var k in o)
                if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
            return fmt;
        }

    </script>
</body>
</html>
