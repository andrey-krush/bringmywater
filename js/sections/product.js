sectionJS(".product",function(t){dynamicListener("click",".add_to_cart_button.loading",function(t){t.preventDefault(),t.stopPropagation(),t.stopImmediatePropagation()}),dynamicListener("change",".quantity__input",function(t){let e=this,a=e.closest(".product");a&&(a.querySelector(".ajax_add_to_cart").dataset.quantity=e.value)}),jQuery(document).on("added_to_cart",function(){trigger(document.querySelector(".cart"),"update",{show:!0}),showNotice(messages.added_to_cart)})});