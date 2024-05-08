function payment_eximbay() {
  var form = document.createElement("form"); // 서버로 입력한 데이터를 보내기 위해서
  document.documentElement.appendChild(form) // html 에 추가
  form.setAttribute("charset", "UTF-8");
  form.setAttribute("name", "regForm");
  form.setAttribute("method", "post"); // post 방식 
  form.setAttribute("action", "eximbay_approval.php"); // 요청 보낼 주소

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "ver");
  hiddenField.setAttribute("value", "230");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "txntype");
  hiddenField.setAttribute("value", "PAYMENT");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "charset");
  hiddenField.setAttribute("value", "UTF-8");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "statusurl");
  hiddenField.setAttribute("value", "https://apsys23.skku.edu/eximbay_status.php");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "returnurl");
  hiddenField.setAttribute("value", "https://apsys23.skku.edu/eximbay_return.php");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "rescode");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "resmsg");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "mid");
  // XXX:
  //hiddenField.setAttribute("value", "1849705C64"); // for test
  hiddenField.setAttribute("value", "30DC43E91F"); // for service
  form.appendChild(hiddenField);
 
  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "ref");
  hiddenField.setAttribute("value", "KIISE(apsys23)");
  //hiddenField.setAttribute("value", "demo20170418202020");
  form.appendChild(hiddenField);
  /*
  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "ref");
  var d = new Date();
  var n = String(d.getTime());
  var email = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[4].value;
  n = email+n;
  n = n.slice(0,68);
  hiddenField.setAttribute("value", n);
  form.appendChild(hiddenField);
  */

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "ostype");
  hiddenField.setAttribute("value", "P");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "displaytype");
  hiddenField.setAttribute("value", "P");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "cur");
  hiddenField.setAttribute("value", "USD");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "amt");
  var infos = document.getElementById('personal_infos').getElementsByTagName('tbody'); 
  var country = infos[0].getElementsByTagName('select')[0].value;
  var reg_type = infos[0].getElementsByTagName('select')[1].value;
  var total_price = 0;
  var non_quantity = 0;
  var acm_quantity = 0;
  var nst_quantity = 0;
  var ast_quantity = 0;
  for (var k=0; k<(infos.length-1); k++){
    if ('ACM' == infos[k].getElementsByTagName('select')[1].value){
      non_quantity += 1;
      total_price += 450; // 400;
    }else if ('NON' == infos[k].getElementsByTagName('select')[1].value){
      acm_quantity += 1;
      total_price += 500; // 450;
    }else if ('AST' == infos[k].getElementsByTagName('select')[1].value){
      nst_quantity += 1;
      total_price += 350; // 300;
    }else if ('NST' == infos[k].getElementsByTagName('select')[1].value){
      ast_quantity += 1;
      total_price += 400; // 350;
    }else{alert('unknown error in Type'); return; }
  }
  hiddenField.setAttribute("value", total_price);
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "shop");
  hiddenField.setAttribute("value", "KIISE(apsys23.skku)");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "buyer");
  var Firstname = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[0].value
  var Middlename = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[1].value
  var Lastname = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[2].value
  var fullname = "";
  if (Middlename == "") {
    fullname = Firstname+' '+Lastname; 
  } else {
    fullname = Firstname+' '+Middlename+' '+Lastname; 
  }
  hiddenField.setAttribute("value", fullname.slice(0,49));
  form.appendChild(hiddenField);

  /*
  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "param1");
  if (infos[0].getElementsByTagName('input')[5].checked) {
    hiddenField.setAttribute("value", "VEGE");
  } else {
    hiddenField.setAttribute("value", "NOVG");
  }
  form.appendChild(hiddenField);
  */
  
  /*
  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "param2");
  if (infos[0].getElementsByTagName('input')[6].checked) {
    hiddenField.setAttribute("value", "NO_TOUR");
  } else if (infos[0].getElementsByTagName('input')[7].checked) {
    hiddenField.setAttribute("value", "ENG");
  } else if (infos[0].getElementsByTagName('input')[8].checked) {
    hiddenField.setAttribute("value", "CHN");
  } else if (infos[0].getElementsByTagName('input')[9].checked) {
    hiddenField.setAttribute("value", "ANY");
  }else {
    hiddenField.setAttribute("value", "NO_TOUR");
  }
  form.appendChild(hiddenField);
  */

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "param3");
  var org = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[3].value;
  if (org.length == 0){
    org = "None";
  }
  var others = "acm_type=" + reg_type + "&";
  var acm_num = -1;
  others += "country=" + country + "&";
  others += "affiliation=" + org + "&";
  if ((reg_type == "ACM") | (reg_type == "AST")) {
    acm_num = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[5].value;
  }
  others += "acm_num=" + acm_num;
  hiddenField.setAttribute("value", others);
  form.appendChild(hiddenField);
  //alert(others);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "email");
  var email = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[4].value;
  hiddenField.setAttribute("value", email);
  form.appendChild(hiddenField);

  /*
  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "tel");
  hiddenField.setAttribute("value", "");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "lang");
  hiddenField.setAttribute("value", "EN");
  form.appendChild(hiddenField);
  */

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "paymethod");
  var tb = document.getElementById("paymethod").getElementsByTagName("tbody");
  var paymethod = tb[0].getElementsByTagName("select")[0].value;
  hiddenField.setAttribute("value", paymethod);
  form.appendChild(hiddenField);

  var prod_name = "ACM SIGOPS APSys 2023 Registration"

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "item_0_product");
  hiddenField.setAttribute("value", prod_name);
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "item_0_quantity");
  hiddenField.setAttribute("value", 1);
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "item_0_unitprice");
  hiddenField.setAttribute("value", total_price);
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "surcharge_0_name");
  hiddenField.setAttribute("value", "");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "surcharge_0_quantity");
  hiddenField.setAttribute("value", 0);
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "surcharge_0_unitprice");
  hiddenField.setAttribute("value", 0);
  form.appendChild(hiddenField);

  submit_eximbay(form);
}

function submit_eximbay(dfm){
  /*
  var x = dfm.elements;
  var txt = "";
  for (i = 0; i < x.length; i++) {
    txt = txt + x[i].name + "=" + x[i].value + "\n";
  }
  //document.getElementById("for_new_body").innerHTML =	txt;
  */

  // async
  setTimeout(function() {
    var email = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[4];
    if (email.value != '') {
      var new_window = window.open("", "payment2", "resizable=yes,scrollbars=yes,width=820,height=600");
      dfm.target = "payment2";
      dfm.submit(); // eximbay_approval 로 submit
    } 
  }, 500);

	/*
	var email = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[4];
	if (email.value != '') {
	  var new_window = window.open("", "payment2", "resizable=yes,scrollbars=yes,width=820,height=600");
	  dfm.target = "payment2";
	  dfm.submit(); // eximbay_approval 로 submit
	} 
	*/
}
