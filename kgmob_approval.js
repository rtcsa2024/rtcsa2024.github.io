function payment_kgmob() {
	// alert("Not support Korean domestic card yet...");

  var form = document.createElement("form"); // 서버로 입력한 데이터를 보내기 위해서
  //document.documentElement.appendChild(form) // html 에 추가
  document.head.appendChild(form) // html 에 추가
  form.setAttribute("charset", "UTF-8");
  form.setAttribute("name", "regForm");
  form.setAttribute("method", "post"); // post 방식 
  form.setAttribute("action", "kgmob_approval.php"); // 요청 보낼 주소

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "Prdtprice");
  var infos = document.getElementById('personal_infos').getElementsByTagName('tbody'); 
  var total_price = 0;
  if ('ACM' == infos[0].getElementsByTagName('select')[1].value){
    total_price += 600000; // 540000; // 400;  
  }else if ('NON' == infos[0].getElementsByTagName('select')[1].value){
    total_price += 660000; // 600000; // 450;
  }else if ('AST' == infos[0].getElementsByTagName('select')[1].value){
    total_price += 460000; // 400000; // 300;
  }else if ('NST' == infos[0].getElementsByTagName('select')[1].value){
    total_price += 530000; // 470000; // 350;
  }else{alert('unknown error in Type'); return; }
  hiddenField.setAttribute("value", total_price);
  form.appendChild(hiddenField);

  var prod_name = "ACM SIGOPS APSys 2023 Registration"
  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "Prdtnm");
  hiddenField.setAttribute("value", prod_name);
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

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "param3");
  var org = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[3].value;
  if (org.length == 0){
    org = "None";
  }

  var country = infos[0].getElementsByTagName('select')[0].value;
  var reg_type = infos[0].getElementsByTagName('select')[1].value;
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

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "email");
  var email = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[4].value;
  hiddenField.setAttribute("value", email);
  form.appendChild(hiddenField);

  var misc = "name=" + fullname.slice(0,49) + "&" + 
    "email=" + email + "&" + others;
  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("name", "misc");
  hiddenField.setAttribute("value", misc);
  form.appendChild(hiddenField);

  submit_kgmob(form);
}

function submit_kgmob(dfm) {
  // async new window 
  setTimeout(function() {
    var email = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[4];
    if (email.value != '') {
      var new_window = window.open("", "payment2", 
        "resizable=yes,scrollbars=yes,width=820,height=600");
      dfm.target = "payment2";
      /*
      dfm.target = "";
      */
      dfm.submit();
    } 
  }, 500);
}
