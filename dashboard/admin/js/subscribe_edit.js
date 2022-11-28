/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

document.querySelectorAll("tbody td").forEach(function(node){
	node.ondblclick=function(){
		let val = this.innerHTML;
        let column = this.getAttribute('name');
        let id_subscribe = this.getAttribute('value');


		let input = document.createElement("input");
        input.className = "form-control";
		input.value = val;      

		input.onblur = function(){
			let val = this.value;
			this.parentNode.innerHTML=val;
            modify_subscribe_content(id_subscribe,column,val);
		}

		this.innerHTML = "";
		this.appendChild(input);
		input.focus();

	}
});

function modify_subscribe_content(id_subscribe,column_name,new_val){
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/modify_subscribe_content.php?id_subscribe="+id_subscribe+"&column_name="+column_name+"&val="+new_val);
    
    request.send();
}

