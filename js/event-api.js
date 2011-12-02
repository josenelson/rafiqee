var last_timestamp = 0;
var canvas_id = 0;
var user_id = 0;
var event_bindings = new Array();

//dispatch_event.php?canvas_id=1&user_id=2&source=1&event_type=[&styles=…&properties=…&content=…]

/*
*
*	Dispatches an event to the server.
*	event_type: the int code for the event
*	source: the source of the event (element or user)
*	canvas_id: the id of the current canvas
*	user_id: the id of the user thats logged in the system
*	options: TODO
*
*/
function dispatch_event(event_type, source, canvas_id, user_id, properties, values, callback) {
	var params = "canvas_id=" + canvas_id + "&user_id=" + user_id + "&source=" + source + "&event_type=" + event_type;
	
	for(var i  = 0; i < values.length; i++) {
		params = params + "&" + properties[i] + '=' + values[i]; 
	}
	
	console.log('dispatching event with params: ' + params);
	
	$.getJSON("./services/dispatch_event.php?" + params, 
		function(data) {
			/* no data is actually expected to be return 
			*	inserting is a special case where a newly create id is being return
			*/
			if(callback) {
				callback(data.data);
			}
		}
	);

}

function bind_event(event_type, callback) {
	event_bindings[event_type] = callback;
}

function start_event_listener(canvas, user, timestamp) {
	last_timestamp = timestamp;
	canvas_id = canvas;
	user_id = user;
	
	listen_for_events();
}

function listen_for_events(){
		var params = "canvas_id=" + canvas_id + "&user_id=" + user_id + "&timestamp=" + last_timestamp;
        $.ajax({
            type: "GET",
            url: "./services/listen_for_events.php?" + params,
			dataType: "json",
            async: true,
            cache: false,

            success: function(data){  
            	        
                last_timestamp = data.timestamp;
                
                console.log("Got data for " + data.events.length + " events.");      
                
                var callback;
                var event;
                
				for(var i = 0; i < data.events.length; i++) {
					
					event = data.events[i];
					callback = event_bindings[event.event_type];
					
					if(typeof(event_bindings[data.events[i].event_type]) != 'undefined') {
						 callback(event.source, event.user_id, event.data);
					}	
					else {
						console.log("callback NOT found");
					}
				}
                setTimeout(
                    'listen_for_events()',
                    500
                );
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                console.log("error: " + textStatus);
                setTimeout(
                    'listen_for_events()',
                    15000
                );
			},
		});
};