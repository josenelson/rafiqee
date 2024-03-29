var id_prefix = "element_";
var type_block = new Array();

type_block['styles'] = 'left:0px,top:34px,width:200px,height:100px';
type_block['properties'] = '';

function styles_from_element(element) {
	
	var styles = type_block['styles'].split(',');
	var styles_str = '';
	
	for(var i = 0; i < styles.length; i++) {
		var map = styles[i].split(':');
		styles_str += map[0] + ':' + element.style[map[0]] + ','; 
	
	}
	
	return styles_str.substring(0, styles_str.length-1);

}

function properties_from_element(element) {
	
	var properties = type_block['properties'].split(',');
	var properties_str = '';
	
	for(var i = 0; i < properties.length; i++) {
		var map = properties[i].split(':');
		properties_str += map[0] + ':' + element.style[map[0]] + ','; 
	
	}
	
	return properties_str.substring(0, properties_str.length-1);

}

function id_from_element(element) {
	var id = element.getAttribute('id');
	
	return id.substring(id_prefix.length, id.length);
}

function div_from_element(element, newdiv) {

	var id = id_prefix + element.id;
								
	newdiv.style.position = "relative";
	newdiv.setAttribute("id", id);
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