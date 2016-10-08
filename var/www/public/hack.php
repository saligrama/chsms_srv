<!DOCTYPE html>

<?php

require("../includes/functions.php");

/*if (!session_id())
	session_start();

if (!checkSession($_GET["CID"]))
	redirectTo('/login.php');
*/

?>

<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<style>

.main {
        max-width: 500px;
        min-width: 400px;
        margin-left: auto;
        margin-right: auto;
}

.main-body {
	padding: 60px 80px;
}

.conversation {
	border-radius: 5px;
	border: 1px solid rgba(100, 100, 100, 255);
	background-color: #eee;
	padding: 20px 35px;
}

.tabs-list {
        list-style-type: none;
        margin: 0;
        padding: 0;
	overflow: hidden;
}

.tab {
        float: left;
	background-color: #000D47;
}

.tab a {
        display: block;
	text-align: center;
	text-decoration: none;
	color: white;
	padding: 14px 16px;
}

.tab a:hover {
	cursor: pointer;
	background-color: #25a;
}

.message-list {
        list-style-type: none;
        -webkit-padding-start: 0;
        position: relative;
	overflow-x: hidden;
	overflow-y: auto;
	padding: 10px;
	margin-bottom: 0;
	height: 500px;
}

.messages-message-heading {
        margin-bottom: 7px;
}

.element-load {
	transition: opacity 1s ease-in-out, transform 1s ease-in-out;
}

.element-loading {
	transform: translate(0, -10px);
	opacity: 0;
}

.message-li .element-loading {
	margin-bottom: -100%;
}

.message-li {
        margin-bottom: 10px;
	width: 100%;
	height: 77px;
}

.message-li-sent {
	float: right;
}

.message-li-from {
	float: left;
}

.message-li-from .messages-message {
	background-color: rgba(150, 150, 250, 255);
	border-top-left-radius: 0;
}

.message-li-sent .messages-message {
	border-top-right-radius: 0;
}

.messages-message {
        background-color: rgba(150, 250, 150, 255);
        border-radius: 4px;
        padding: 15px 20px;
	max-width: 200px;
}

.messages-message:before {
	content:"";
	position: absolute;
	right: 100%;
	top: 0;
	width: 0;
	height: 0;
	border-right: 8px solid rgba(150, 150, 250, 255);
	border-bottom: 7px solid transparent;
}

.message-li-sent .messages-message:before {
	left: 100%;
	border-right: none;
	border-left: 8px solid rgba(150, 250, 150, 255);
}

.message-li-sent .message-wrapper {
	margin-right: 8px;
}

.message-wrapper {
	display: inline-block;
	position: relative;
	margin-left: 2px;
}

.messages-message-text {
        font-size: 14px;
        margin: 0;
	word-wrap: break-word;
}

.messages-info {
        padding: 4px 10px;
        text-align: right;
        color: rgba(100, 100, 100, 255);
        font-size: 12px;
}

.message-li-from .messages-info {
	text-align: left;
}

.message-info .glyphicon {
        transform: scale(0.8, 0.8);
}

.messages-message-name {
        font-weight: 600;
}

.message-pic {
	display: inline-block;
	vertical-align: top;
}

.message-pic img {
	border-radius: 50%;
	width: 30px;
	height: 30px;
}

.new-message input {
	border-radius: 0;
	padding: 12px 10px;
}

.message-info-date {
	font-size: 10px;
	color: #777;
}

.message-info-date-error {
	color: #c22;
	font-weight: 500;
}

.message-li-sent .message-info {
	text-align: right;
}

</style>

<script>

function db_Connect()
{
	var xhttp;
	if(window.XMLHttpRequest)
    		xhttp = new XMLHttpRequest();
    	else
    		xhttp = new ActiveXObject("Microsoft.XMLHTTP");

	return xhttp;
}

function checkLoaders()
{
	var lis = document.getElementsByClassName("element-load");

        for(var i = 0; i < lis.length; i++)
                lis[i].classList.remove("element-loading");
}

function scrollToBottom(e, t)
{
	var ipos = e.scrollTop;
	var fpos = e.scrollHeight - e.clientHeight;
	var diff = fpos - ipos;

	var dt = 5;
	var step = diff / (t / dt);

	if(step)
	{
		var id = window.setInterval(frame, dt);
		var count = 0;
		function frame()
		{
			if(count == (t / dt))
				window.clearInterval(id);
			else
				e.scrollTop = step*count++ + ipos;
		}
	}

}

function callback()
{
	checkLoaders();
	getMessages(1);
}

function init()
{
        window.setInterval(callback, 100);

	getMessages(1);
}

function showMessage(mes, UID, MID = 0)
{
	if(typeof showMessage.TID == 'undefined')
                showMessage.TID = 0;

	var li = document.createElement("LI");
        var ul = document.getElementById("message-list");
        ul.appendChild(li);

        li.outerHTML = "<li class=\"message-li element-load element-loading\"" + "data-uid='" + <?php echo $_GET["UID"] ?> + "' " + (MID ? ("data-mid='" + MID) : ("data-tid='" + ++(showMessage.TID))) + "'>" +
                                "<div class=" + (UID == <?php echo $_GET['UID']; ?> ? "'message-li-sent'" : "'message-li-from'" ) + ">" +
                                        "<div class=\"message-wrapper\">" +
                                                "<div class=\"messages-message\">" +
                                                        "<p class=\"messages-message-text\">" +
                                                                 mes +
                                                        "</p>" +
                                                "</div>" +
                                                "<div class=\"message-info\">" +
                                                        "<span class=\"message-info-date\">Sent</span>" +
                                                "</div>" +
                                        "</div>" +
                                "</div>" +
                        "</li>";

	return showMessage.TID;
}

function sendMessage(mes)
{
	var d = new Date();
	var time = d.getTime();

	if(typeof sendMessage.lastTime == 'undefined')
        	sendMessage.lastTime = time;
	else if(time - sendMessage.lastTime < 200)
		return;
	else
		sendMessage.lastTime = time;

	var tid = showMessage(mes, <?php echo $_GET["UID"]; ?>);

	scrollToBottom(document.getElementById("message-list"), 400);

        var xhttp = db_Connect();

        xhttp.onreadystatechange = function()
        {
                if(this.readyState == 4 && this.status == 200)
		{
			var ul = document.getElementById("message-list");
			var lis = ul.getElementsByClassName("message-li");
//alert(this.responseText);

			if(this.responseText == 0)
			{
				for(var i = 0; i < lis.length; i++)
                                        if(lis[i].dataset.tid == tid)
					{
                                                var date = lis[i].getElementsByClassName("message-info-date")[0];
						date.innerHTML = "Error sending";
						date.classList.add("message-info-date-error");
					}
			}
			else
			{
				var array = JSON.parse(this.responseText);

				for(var i = 0; i < lis.length; i++)
				{
					if(lis[i].dataset.tid == tid)
					{
						lis[i].getElementsByClassName("message-info-date")[0].innerHTML = "Sent";
        					lis[i].dataset.tid = 0;
						lis[i].dataset.mid = parseInt(array[0]["MID"]);
					}
				}
			}
		}
	};

	xhttp.open("POST", "messages.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("UID=" + <?php echo $_GET["UID"]; ?> + "&CID=1&Mes=" + mes + "");
}

function messageKey(e, elem)
{
	if(e.keyCode == 13)
	{
		if(elem.value.trim() !== "")
			sendMessage(elem.value);
		elem.value = "";
	}
}

function getMessages(CID)
{
	var ul = document.getElementById("message-list");
	var lis = ul.getElementsByClassName("message-li");

	var xhttp = db_Connect();

        xhttp.onreadystatechange = function()
        {
                if(this.readyState == 4 && this.status == 200)
                {
		//alert(this.responseText);
			var array = JSON.parse(this.responseText);

			var mids = [];
			for(var i = 0; i < lis.length; i++)
				mids[i] = parseInt(lis[i].dataset.mid);

			for(var i = 0; i < array.length; i++)
			{
				if(mids.indexOf(parseInt(array[i]["MID"])) == -1)
				{
					showMessage(array[i]["text"], parseInt(array[i]["UID"]), parseInt(array[i]["MID"]));
					scrollToBottom(document.getElementById("message-list"), 400);
				}
			}
		}
        };

	        xhttp.open("POST", "messages.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("getMes=1&CID=" + CID);
}

</script>

</head>

<body onload="init()" class="body-loading">
        <div class="main">
                <div class="main-header">
                </div>
                <div class="main-tabs">
                        <ul class="tabs-list">
                        </ul>
                </div>
                <div class="main-body element-load element-loading">
			<div class="conversation">
				<ul class="message-list" id="message-list">
				</ul>
				<div class="new-message">
					<input onkeydown="messageKey(event, this);" type="text" class="form-control" placeholder="Send a message"></input>
				</div>
			</div>
                </div>
        </div>
</body>


</html>

