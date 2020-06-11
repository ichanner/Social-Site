const Discord = require("discord.js");
const bot = new Discord.Client();

const token = 'NzIwNTI1NDQxNjcyMTUxMTMz.XuHPxw.TQc23v7w5lAksXdFV0P6Ya0hcp8';


bot.on('ready', () =>{


	console.log("FinestBot is Online!");

})


bot.on('message', msg=> {


if (msg.channel.id == '709990380204195892'){ 	
	
	if(msg.author != '710016789387411487'){

		var message = msg.content;
		var sender  = msg.member.user.tag;
		var channel = "Public-US";

		var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
		var xhr = new XMLHttpRequest();

		const url='http://localhost/MegaTowel/BotSend.php?msg='+message+"&name="+channel+"&sender="+sender;
		xhr.open("POST", url);
		xhr.send();

	}

}})

bot.login(token);