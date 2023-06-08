"use strict";

const _parseErrors = (errMessage) => {
let arr_error = [];
if (typeof errMessage === 'string') {
   arr_error.push(errMessage);
} else {
   Object.keys(errMessage).forEach(function(key) {
      if(!arr_error.includes(errMessage[key])){
         arr_error.push(errMessage[key]);
      }
   });
}

return arr_error.join('<br/>');
}

const _parseForm = (form_id) => {
   var frm = document.getElementById(form_id);
   var ret = '';
   if (frm) {
      var input = new Array('input', 'select', 'textarea', 'password', 'button');
      for (let ix = 0; ix < input.length; ix++) {
         var el = frm.getElementsByTagName(input[ix]);
         for (var i = 0; i < el.length; i++) {
               if (!el[i].name)
                  continue;
               switch (el[i].type) {
                  case 'radio':
                  case 'checkbox':
                     if (el[i].checked) {
                           ret += '@@' + el[i].name + '^^' + el[i].value
                     }
                     break;
                  default:
                     ret += '@@' + el[i].name + '^^' + el[i].value
                     break;
               }
         }
      }
   }
   ret = urlencode(ret.substring(2));
   return ret;
}

function urlencode(Va) {
   if (encodeURIComponent)
      return encodeURIComponent(Va);
   if (escape)
      return escape(Va)
}