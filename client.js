$(function() {
					  var socket = io.connect("http://"+location.hostname+":3000");
		
					  //socket.emit('name', );
					  socket.json.emit('init', { 'id': my_id , 'name': my_name});
					  socket.on('init_ack', function(data) {
					  var name;
						for (var i = data.length-1; i >=0 ; i--) { 
						data[i].comments = $('<div/>').text(data[i].comments).html();
						data[i].name = $('<div/>').text(data[i].name).html();
							$('#chat_log').prepend(data[i].name+'> '+data[i].comments + '<br><hr>');
						}


					  });
					  $('#chat').submit(function() {
						
						socket.emit('msg', $('#message').val());
						$('#message').val('');
						return false;
					  });
					  socket.on('msg', function(data) {
					  var name;
					  data = $('<div/>').text(data).html();

						$('#chat_log').prepend(data + '<br><hr>');
							/*var audio = new Audio("http://"+location.hostname+":80/mp3/test.mp3");
							audio.volume=1;
							audio.play();*/
					  });

					});