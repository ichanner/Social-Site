
var socket = require('socket.io'),
	express = require('express'),
	https = require('https'),
	http = require('http'),
	port = 2001,
	logger = require('winston');




logger.remove(logger.transports.Console);
logger.add(logger.transports.Console,{ colorize: true, timestamp: true});
logger.info('SocketIO > listening on port '+port);


const Discord = require("discord.js");
const bot = new Discord.Client();

const channel_id = '709990380204195892';
const websocket_id = '710016789387411487';
const token = 'NzIwNTI1NDQxNjcyMTUxMTMz.XuHPxw.TQc23v7w5lAksXdFV0P6Ya0hcp8';

var app = express();
var http_server = http.createServer(app).listen(port);


function emitNewOrder(http_server){

	var io = socket.listen(http_server);
	
	io.sockets.on('connection',function(socket){
		
		socket.on("new_msg",function(data){
			console.log(data);
			io.emit("new_msg",data); 
		})

	});
}

emitNewOrder(http_server); 



bot.on('ready', () =>{


	console.log("FinestBot is Online!");

})


bot.on('message', msg=> {


if (msg.channel.id == channel_id){ 	
	
	if(msg.author != websocket_id){

		var message = msg.content;
		var sender  = msg.member.user.tag;
		var channel = "Public-US";

		var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
		var xhr = new XMLHttpRequest();

		const url='http://localhost/MegaTowel/BotSend.php?msg='+message+"&name="+channel+"&sender="+sender;
		xhr.open("POST", encodeURI(url));
		xhr.send();

	}

}})

bot.login(token);
