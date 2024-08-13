const only_num=/^[0-9.]+$/,tel_reg=/^[0-9+]+$/,only_num_replace=/[^0-9.]/g,tel_reg_replace=/[^0-9+]/g,password_reg=/^(?=.*[a-zA-Z])(?=.*\d).*$/,email_reg=/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/,username_reg=/^[a-zA-Z0-9._-]{1,60}$/,email_reg_full=/^(([^<>()\[\]\\.,;:\s@"]{2,62}(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z-аА-яЯ\-0-9]+\.)+[a-zA-Z-аА-яЯ]{2,62}))$/,validationRules={email:{rules:{regex:email_reg}},email_username:{rules:{email_username:[email_reg_full,username_reg]}},emailfull:{rules:{regex:email_reg_full}},numeric:{rules:{regex:only_num}},"numeric-replace":{rules:{regexReplace:only_num_replace}},phone:{rules:{regexReplace:tel_reg_replace}},password:{rules:{regex:password_reg}},password_repeat:{rules:{password_repeat:!0}},delivery_term_date:{rules:{delivery_term_date:!0}}},validationMethods={email_username:function(e,t,o){return""==e||new RegExp(e.indexOf("@")>-1?o[0]:o[1]).test(e)},delivery_term_date:function(e,t){let o=parseInt(t.dataset.daysOffset)||0,n=new Date;return!e||(e=new Date(e),n.setDate(n.getDate()+o),e.setHours(0,0,0,0),n.setHours(0,0,0,0),n<=e)}};function formReset(e){void 0!==e.dataset.noReset||e.classList.contains("no-reset")||(e.reset(),e.querySelectorAll(".output_value").forEach(e=>e.value=""),e.querySelectorAll(".is-selected").forEach(e=>e.classList.remove("is-selected")),e.querySelectorAll(".image-preview").forEach(e=>e.remove()),e.querySelectorAll(".ql-editor").forEach(e=>e.innerHTML=""),e.querySelectorAll(".is-visible").forEach(e=>e.classList.remove("is-visible")))}function ajaxSuccess(e,t,o){t=t.responseJSON||t.data||t;let n=e.dataset.successPopup,c=e.querySelector('[type="submit"]'),a=e.closest(".show-hide-on-success")||e.closest("section")||e,r=a.querySelector(".show-on-success"),s=a.querySelector(".hide-on-success"),i=t.redirect_url||t.redirect||e.dataset.redirect;e.ajaxSuccess&&e.ajaxSuccess(e,t,o),setTimeout(function(){Fancybox.close(),n&&Fancybox.show([{src:n,type:"inline",placeFocusBack:!1,trapFocus:!1,autoFocus:!1}],{dragToClose:!1})},100),i?window.location.href=i:(c&&c.removeAttribute("disabled"),s?fadeOut(s,300,function(){r&&fadeIn(r,300)}):r&&fadeIn(r,300),formReset(e))}function ajaxError(e,t){t=t.responseJSON||t.data||t;let o=e.querySelector('[type="submit"]'),n=e.dataset.errorPopup;if(e.ajaxError&&e.ajaxError(e,t),n&&setTimeout(function(){Fancybox.close(),Fancybox.show([{src:n,type:"inline",placeFocusBack:!1,trapFocus:!1,autoFocus:!1}],{dragToClose:!1,on:{destroy:e.afterErrorPopup}})},100),o&&o.removeAttribute("disabled"),"object"==typeof t&&t.errors){let o=!1;Object.keys(t.errors).forEach(n=>{let c=e.querySelector(`[name="${n}"]`);c&&c.setError&&(c.setError(t.errors[n]),o||(document.scrollTo&&document.scrollTo(c,700),o=!0))})}}function onSubmit(e,t=!1){let o=t||new FormData(e),n=e.getAttribute("action")||"/wp-admin/admin-ajax.php",c=e.getAttribute("method")||"post",a=e.querySelector('[type="submit"]'),r=e.querySelectorAll(".ql-editor"),s=new XMLHttpRequest;r.length&&r.forEach(function(e){let t=e.closest("[data-name]");e.querySelectorAll(".ql-emojiblot").forEach(function(e){e.outerHTML=e.textContent});let n=e.innerHTML;t&&(t=t.dataset.name,o.append(t,n))}),a&&a.setAttribute("disabled","disabled"),s.open(c,n),s.send(o),s.onload=function(){let t=s.responseText;try{t=JSON.parse(t)}catch(e){}200===s.status?ajaxSuccess(e,t,o):ajaxError(e,t)}}let sectionsJS={};function sectionJS(e="",t){e&&"function"==typeof t&&(sectionsJS[e]=t)}function marquee(e,t){const o=e.innerHTML;let n=e.children[0],c=0,a=!0;e.insertAdjacentHTML("beforeend",o),e.insertAdjacentHTML("beforeend",o),setTimeout(function(){e.classList.contains("dir-right")&&(a=!1,e.style.justifyContent="flex-end",n=e.children[e.children.length-1]),setInterval(function(){a?n.style.marginLeft=`-${c}px`:n.style.marginRight=`-${c}px`,c>n.clientWidth&&(c=0),c+=t},0)},1e3)}function showNotice(e="",t=!0){if(!e)return;let o=document.querySelector(".header-notice"),n=document.createElement("span");n.textContent=e,n.style.display="none",t&&n.classList.add("header-notice--cart"),o.append(n),setTimeout(function(){fadeIn(n,300,"flex")},20),setTimeout(function(){fadeOut(n,300,function(){n.remove()})},2e4)}function doRecaptchaV3(e=(()=>{})){if("undefined"!=typeof grecaptcha){if("function"==typeof grecaptcha.execute)e(grecaptcha);else{let t=setInterval(function(){"function"==typeof grecaptcha.execute&&(clearInterval(t),e(grecaptcha))},50)}return}let t=document.createElement("script");t.onload=function(t,o,n){let c=setInterval(function(){"undefined"!=typeof grecaptcha&&"function"==typeof grecaptcha.execute&&(clearInterval(c),e(grecaptcha))},50)},t.src="https://www.google.com/recaptcha/api.js?render=6Lf1YwcqAAAAALajxLHIlMVzOvuFg_wr2cSvZtLj",document.querySelector("body").append(t)}function blocks(){let e={...{".input--select":function(e){function t(e){let t=e.target;if(e.nodeName&&(t=e),t.classList.contains("input__search")||t.querySelector("a"))return;let o=t.closest(".input--select"),n=o.classList.contains("output-html")?t.innerHTML.trim():t.textContent.trim(),c=t.dataset.value,a=o.querySelector(".output_text"),r=o.querySelector(".output_value");o.classList.contains("no-output")||a&&n&&("input"===a.nodeName.toLowerCase()?a.value=n:a.innerHeight=n),r&&(r.value=c,"function"==typeof r.isValid&&r.isValid(),"function"==typeof trigger&&trigger(r,"change")),t.classList.add("is-selected"),Array.from(t.parentElement.children).forEach(function(e){e!=t&&e.classList.remove("is-selected")}),o.classList.contains("has-checkbox")||trigger("close-dropdown")}dropdown({globalContainer:"",containerClass:"input--select",btnSelector:".output_text",closeBtnClass:"",dropdownSelector:".input__dropdown",effect:"fade",timing:300,closeOnClick:!1}),dynamicListener("click",".input--select li",t),document.querySelectorAll(".input--select").forEach(function(e){let o=e.querySelector(".is-selected");if(!o){let t=e.querySelector(".output_value").value;t&&(o=e.querySelector('[data-value="'+t+'"]'))}o&&t(o)})},".marquee .marquee__content":function(e){e.forEach(function(e){window.innerWidth<768?marquee(e,.2):marquee(e,.5)})},".quantity":function(e){let t=0;dynamicListener("click",".quantity__btn",function(e){let o,n=e.target.closest(".quantity"),c=e.target.closest(".quantity__btn")||e.target,a=c.getAttribute("data-direction"),r=c.closest(".quantity__amount").querySelector(".quantity__input"),s=+r.value,i=parseInt(r.getAttribute("min")),u=parseInt(r.getAttribute("max"));"plus"===a?o=isNaN(u)?s+1:s+1<=u?s+1:u:(isNaN(i)&&(i=1),o=s-1>=i?s-1:i),r.value=o,trigger(r,"change"),clearTimeout(t),t=setTimeout(function(){trigger(n,"change_quantity",o)},1e3)})},".cart":function(){let e=document.querySelector(".cart"),t=document.querySelector(".js-open-cart"),o=document.querySelector(".page__body");function n(){fadeIn(e,300),setTimeout(function(){e.classList.add("is-open"),o.classList.add("cart-open"),t.classList.add("is-active")},300)}function c(){e.classList.remove("is-open"),setTimeout(function(){fadeOut(e,300),o.classList.remove("cart-open"),t.classList.remove("is-active")},300)}function a(t,o,c="",a=!0){let r=new XMLHttpRequest;e.classList.add("is-loading"),jQuery(".woocommerce-checkout-review-order-table").length&&jQuery(".woocommerce-checkout-review-order-table").block({message:null,overlayCSS:{background:"#fff",opacity:.6}}),r.open("post","/wp-admin/admin-ajax.php"),r.send(t),r.onload=function(){let t=r.responseText;var s;200===r.status&&(s=t,e.querySelector(".cart__body").innerHTML=s,trigger(document.body,"update_checkout"),setTimeout(function(){trigger(document.body,"update_count")},50),c&&showNotice(c,a),o&&n()),e.classList.remove("is-loading")}}dynamicListener("click",".js-open-cart",n),dynamicListener("click",".cart__close",function(){c()}),document.addEventListener("click",function(o){e.contains(o.target.closest(".cart__container"))||!t||t.contains(o.target)||c()}),document.addEventListener("update_count",function(){let e=document.querySelectorAll(".cart-item"),t=0;e.forEach(function(e){let o=e.querySelector(".quantity__input");o&&(t+=parseInt(o.value))}),document.querySelector(".header__btn-num span").textContent=t}),dynamicListener("change_quantity",".cart-item .quantity",function(){let e=new FormData,t=this.closest(".cart-item").dataset.productId,o=this.querySelector(".quantity__input").value;e.append("action","change_cart_quantity"),e.append("product_id",t),e.append("quantity_value",o),a(e)}),dynamicListener("submit",".checkout__code-form",function(e){e.preventDefault();let t=new FormData,o=this.querySelector(".checkout__code-input input").value;t.append("action","apply_coupon"),t.append("coupon",o),a(t,!1,messages.added_promocode,!1)}),dynamicListener("update",".cart",function(e){let t=new FormData;t.append("action","update_cart"),a(t,e.detail.show)}),dynamicListener("input",".checkout__code-input input",function(){let e=this.closest(".checkout__code-form"),t=e.querySelector("button");t.setAttribute("disabled","disabled"),this.value?(e.classList.add("is-focus"),t.removeAttribute("disabled")):(e.classList.remove("is-focus"),e.classList.remove("has-error"),t.setAttribute("disabled","disabled"))})},".js-toggle-account":function(e){let t=(e=e[0]).querySelector(".header__modal");e.addEventListener("click",function(){fadeIn(t,300),e.classList.add("is-active")}),document.addEventListener("click",function(o){t.contains(o.target.closest(".header__modal-inner"))||e.contains(o.target)||setTimeout(function(){fadeOut(t,300),e.classList.remove("is-active")},50)})},".form":function(e){e.forEach(function(e){e.ajaxError=function(t,o){void 0===o.available||o.available||Fancybox.show([{src:"#popup-zip-incorrect",type:"inline",placeFocusBack:!1,trapFocus:!1,autoFocus:!1}],{dragToClose:!1,on:{destroy:e.afterErrorPopup}})},validate(e,{submitFunction:onSubmit})})},".header__burger":function(e){e=e[0];let t=document.querySelector(".menu"),o=document.querySelector(".page__body");e.addEventListener("click",function(){t.classList.toggle("is-active"),e.classList.toggle("is-active"),o.classList.toggle("menu-open")}),document.addEventListener("click",function(n){t.contains(n.target.closest(".menu__inner"))||!e||e.contains(n.target)||(t.classList.remove("is-active"),e.classList.remove("is-active"),o.classList.remove("menu-open"))})},".js-float-btn":function(){window.addEventListener("scroll",function(){let e=document.querySelector(".js-float-btn"),t=e.closest(".checkout").offsetHeight;window.scrollY<t-window.innerHeight+e.offsetHeight?e.classList.contains("is-show")||e.classList.add("is-show"):e.classList.contains("is-show")&&e.classList.remove("is-show")})},'a[href="#popup-password"]':function(e){e.forEach(e=>e.addEventListener("click",function(e){e.preventDefault(),Fancybox.close(),Fancybox.show([{src:"#popup-password",type:"inline",placeFocusBack:!1,trapFocus:!1,autoFocus:!1}],{dragToClose:!1})}))},"#popup-zip form":function(e){e=e[0];let t=getCookie("zip_checked"),o=document.querySelector(".product, .checkout"),n=document.querySelectorAll('a[href="#popup-zip"], a.check-zip');console.log(e,"sdfsdfsd"),validate(e,{submitFunction:function(){let t=e.querySelector('[type="submit"]');t&&t.setAttribute("disabled","disabled"),doRecaptchaV3(function(){grecaptcha.execute("6Lf1YwcqAAAAALajxLHIlMVzOvuFg_wr2cSvZtLj").then(function(t){let o=new FormData(e);o.append("token",t),onSubmit(e,o)})})}}),n.forEach(t=>t.addEventListener("click",function(o){o.preventDefault(),Fancybox.close(),Fancybox.show([{src:"#popup-zip",type:"inline",placeFocusBack:!1,trapFocus:!1,autoFocus:!1}],{dragToClose:!1,on:{done:(o,n,c)=>{e.ajaxSuccess=function(e,o){(void 0===o.available||o.available)&&(setCookie("zip_checked","true",30),t.href&&-1===t.href.indexOf("#")&&(document.location.href=t.href))}}}})})),e.afterErrorPopup=function(){document.location.href="/"},!t&&o&&(Fancybox.close(),Fancybox.show([{src:"#popup-zip",type:"inline",placeFocusBack:!1,trapFocus:!1,autoFocus:!1}],{dragToClose:!1,on:{done:(o,n,c)=>{e.ajaxSuccess=function(e,o){(void 0===o.available||o.available)&&(t=!0,setCookie("zip_checked","true",30))}},destroy:(e,o,n)=>{t||(document.location.href="/")}}}))},".contact__form":function(e){console.log("fsfsef"),e.forEach(function(e){validate(e,{submitFunction:function(){let t=e.querySelector('[type="submit"]');t&&t.setAttribute("disabled","disabled"),doRecaptchaV3(function(){grecaptcha.execute("6Lf1YwcqAAAAALajxLHIlMVzOvuFg_wr2cSvZtLj").then(function(t){let o=new FormData(e);o.append("token",t),onSubmit(e,o)})})}})})},".header":function(){dropdown({globalContainer:"",containerClass:"dropdown",btnSelector:">span",closeBtnClass:"",dropdownSelector:".dropdown__list",effect:"slide",timing:200,closeOnClick:!0})}},...sectionsJS};Object.keys(e).forEach(t=>{document.querySelector(t)&&e[t](document.querySelectorAll(t))})}document.addEventListener("DOMContentLoaded",function(){blocks(),"undefined"!=typeof Fancybox&&Fancybox.bind("[data-fancybox]",{dragToClose:!1})});