function Ajax(Objeto){if(!Objeto.Url){return"Obrigatorio o uso: \"Url: 'caminho do servidor'\"";}var ogr=this;if(window.XMLHttpRequest){this.request=new XMLHttpRequest();if(this.request.overrideMimeType){this.request.overrideMimeType('text/xml');}}else if(window.ActiveXObject){try{this.request=new ActiveXObject("Msxml2.XMLHTTP");}catch(e){try{this.request=new ActiveXObject("Microsoft.XMLHTTP");}catch(e){}}}this.request.onreadystatechange=function(){if(ogr.request.readyState==4){if(ogr.request.status==200){if(navigator.appName=='Natscape'){ogr.request.responseXML.normalize();}if(Objeto.funcao){new Objeto.funcao(ogr.request);}}else{if(Objeto.ajaxErro){new Objeto.ajaxErro();}}}};this.request.open('GET',Objeto.Url,true);this.request.send(null);};