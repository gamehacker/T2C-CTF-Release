var mysql = require('mysql');
var chat_log=[];
var ans_log=[];
var connection = mysql.createConnection({
	host: 'localhost',
	database: 'T2CCTF',
	user: 'username',
	password: 'password'
});

function htmlspecialchars(ch) {
    ch = ch.replace(/&/g,"&amp;") ;
    ch = ch.replace(/"/g,"&quot;") ;
    ch = ch.replace(/'/g,"&#039;") ;
    ch = ch.replace(/</g,"&lt;") ;
    ch = ch.replace(/>/g,"&gt;") ;
    return ch ;
} 

function htmlspecialchars_decpde(ch) {
    ch = ch.replace(/&amp;/g,"&") ;
    ch = ch.replace(/&quot;/g,"\"") ;
    ch = ch.replace(/&#039;/g,"\'") ;
    ch = ch.replace(/&lt;/g,"<") ;
    ch = ch.replace(/&gt;/g,">") ;
    return ch ;
}

function mysqlEscape(stringToEscape){
    return stringToEscape
        .replace("\\", "\\\\")
        .replace("\'", "\\\'")
        .replace("\"", "\\\"")
        .replace("\n", "\\\n")
        .replace("\r", "\\\r")
        .replace("\x00", "\\\x00")
        .replace("\x1a", "\\\x1a");
}

var fs = require('fs');
var app = require('http').createServer(function(req, res) {
  res.writeHead(200, {'Content-Type': 'text/html'});
  //res.end(fs.readFileSync('chat.html'));  
}).listen(3000);
var io = require('socket.io').listen(app);
io.sockets.on('connection', function(socket) {
 var id,name;
  socket.on('init', function(req) {
	socket.set('id',req.id);
	socket.set('name',req.name);
	
	if(req.id=="admin"){
		socket.join('admin');
	}


	var query = connection.query('SELECT * FROM `chat_log`order by no desc LIMIT 30;', function (err, results) {

		chat_log=results;
		io.sockets.json.emit('init_ack', chat_log);
	});
		//console.log(chat_log);
	
	
  });
  socket.on('msg', function(data) {
    socket.get('id',function (err, _id) {
	  id=_id;
    });
    socket.get('name',function (err, _name) {
      //console.log(_name + ' says: ' + data);
	  name=mysqlEscape(htmlspecialchars_decpde(_name));
    });
    io.sockets.emit('msg', name+'> '+data);
	var query = connection.query('insert into chat_log (id,name,comments) values(\''+id+'\',\''+name+'\',\''+data+'\');', function (err, results) {console.log(err);});
  });
  socket.on('atari', function(req) {

	console.log(req.id);
	var query = connection.query('SELECT * FROM team order by points desc ;', function (err, results) {
		io.sockets.to("admin").json.emit('score_update', results);
	});

	var query = connection.query('SELECT * FROM `ans_log` where q_no='+req.q_no+' and id=\''+req.id+'\';', function (err, results) {

		ans_log=results;
		
		io.sockets.to("admin").json.emit('hit', ans_log);
	});

	


	
  });
});


