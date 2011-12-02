var id_prefix = "element_";
var type_block = new Array();
var timestamp = 0;

type_block['styles'] = 'left:0px,top:34px,width:200px,height:100px';
type_block['properties'] = '';


/*
*	Loads the elements from the database that are associated with a canvas
*	and adds them to the container div
*/
function load_elements(container_id, canvas_id, user_id, element_callback, finished_callback) {
	$.getJSON("./services/get_elements_ajax.php?canvas_id=" + canvas_id + "&user_id=" + user_id, 
		function(data) {
			timestamp = data.timestamp;
			for(var i = 0; i < data.elements.length; i++) {
								
				var newdiv = document.createElement('div');
				newdiv.setAttribute("id", element_from_id(data.elements[i].id));
					
				div_from_element(data.elements[i], newdiv);
								
				$("#" + container_id)[0].appendChild(newdiv);
								
				element_callback(newdiv.getAttribute('id'));
			}
			finished_callback(timestamp);
	});

}


/*
*	Returns a associative array of styles
*	that that are being monitored for the element.
*/
function styles_from_element(element) {
	
	if(type_block['styles'] == '') return '';
	
	var styles = type_block['styles'].split(',');
	var styles_str = '';
	
	for(var i = 0; i < styles.length; i++) {
		var map = styles[i].split(':');
		styles_str += map[0] + ':' + element.style[map[0]] + ','; 
	
	}
	
	return styles_str.substring(0, styles_str.length-1);

}

/*
*	Content from element
*/
function content_from_element(element) {
	
	return element.innerHTML;

}


/*
*	Returns a associative array of properties
*	that that are being monitored for the element.
*/
function properties_from_element(element) {
	
	if(type_block['properties'] == '') return '';
	
	var properties = type_block['properties'].split(',');
	var properties_str = '';
	
	for(var i = 0; i < properties.length; i++) {
		var map = properties[i].split(':');
		properties_str += map[0] + ':' + element.style[map[0]] + ','; 
	
	}
	
	return properties_str.substring(0, properties_str.length-1);

}

/*
*	Return the database id of the given element
*
*/
function id_from_element(element) {
	var id = element.getAttribute('id');
	
	return id.substring(id_prefix.length, id.length);
}

/*
*	Return the local element id form a db id
*
*/ 
function element_from_id(id){
	return id_prefix + id;
}

/*
*	Creates a div from the db information 
*	supplied.
*/
function div_from_element(element, newdiv) {


	newdiv.style.position = "relative";
	newdiv.setAttribute("class", "ui-widget-content");
	newdiv.innerHTML = element.content;
										
	var properties = element.properties.split(',');
								
	for(var j = 0; j < properties.length; j++) {
		if(properties[j].length == 0) continue;
		
		var map = properties[j].split(':');
		newdiv.setAttribute($.trim(map[0]), $.trim(map[1]));
	}
								
	var styles = element.styles.split(',');
	for(var j = 0; j < styles.length; j++) {
		var map = styles[j].split(':');
		newdiv.style[$.trim(map[0])] = $.trim(map[1]);
	}
	
}