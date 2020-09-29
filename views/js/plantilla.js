/* ===================================================
  PAGE DOMAIN
===================================================*/

var urlActual = window.location.href;
var arrayUrlApp = urlActual.split('/');
var protocoloArray = urlActual.split(':');
var protocolo = protocoloArray[0];
var dominioApp = protocolo + "://" + window.document.domain;

console.log(dominioApp);
