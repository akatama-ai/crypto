!function(n){n.fn.extend({donetyping:function(e,t){t=t||1e3;var u,i=function(n){u&&(u=null,e.call(n))};return this.each(function(e,o){var r=n(o);r.is(":input")||r.is("textarea")&&r.on("keyup keypress",function(e){var r=[16,17,18,20,35,36,37,38,39,40,45,144,225];"keyup"==e.type&&-1!==n.inArray(e.keyCode,r)||(u&&clearTimeout(u),u=setTimeout(function(){i(o)},t))}).on("blur",function(){i(o)})})}})}(jQuery);