/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */

"use strict";

function send_post_method( key,value,url )
{
	var form = document.createElement("form");
		form.method = "post";
		form.action = url;
	var input = document.createElement("input");
		input.type  = "hidden";
		input.name  = key;
		input.value = value;
	form.appendChild( input );
	console.log(form);
	document.body.appendChild( form );
	form.submit();
}
function like( post_id)
{
	var method 		= 	"POST";
	var url 		=	"post_condition";
	var form_data 	=	 new FormData();
	form_data.append( "post_id",post_id );
	form_data.append( "operation","put_like" );

	var http 		= 	window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	http.open( method, url, true);
	http.onreadystatechange= function(){
							if(this.readyState == 4 && this.status == 200)
							{
								var response = JSON.parse( this.responseText );
								if( response.appresponse == "success" )
								{
									document.getElementById( "like_count" ).innerHTML = response.new_like_count;
									document.getElementById( "like_btn" ).removeAttribute("onclick");
									document.getElementById( "like_btn" ).setAttribute("onclick", "unlike('"+post_id+"')");
									document.getElementById( "like_btn" ).innerHTML = "Unlike";
								}
								else 
								{
									document.getElementById( "like_count" ).innerHTML = response.errorMessage;
								}
							}
						};
	http.send( form_data );
}
function unlike( post_id )
{
	var method 		= 	"POST";
	var url 		=	"post_condition";
	var form_data 	=	 new FormData();
	form_data.append( "post_id",post_id );
	form_data.append( "operation","put_unlike" );

	var http 		= 	window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	http.open( method, url, true);
	http.onreadystatechange= function(){
							if(this.readyState == 4 && this.status == 200)
							{
								var response = JSON.parse( this.responseText );
								if( response.appresponse == "success" )
								{
									document.getElementById( "like_count" ).innerHTML = response.new_like_count;
									document.getElementById( "like_btn" ).removeAttribute("onclick");
									document.getElementById( "like_btn" ).setAttribute("onclick", "like('"+post_id+"')");
									document.getElementById( "like_btn" ).innerHTML = "Like";
								}
								else 
								{
									document.getElementById( "like_count" ).innerHTML = response.errorMessage;
								}
							}
						};
	http.send( form_data );
}