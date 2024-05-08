var script = document.createElement('script');
script.src = 'eximbay_approval.js';
document.head.appendChild(script);
var script = document.createElement('script');
script.src = 'kgmob_approval.js';
document.head.appendChild(script);

function submit() {
  /* check required fileds */
  var fname = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[0];
  if (fname.value == "") {
    alert("Please type in your first name.");
    return;
  }

  var fname = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[2];
  if (fname.value == "") {
    alert("Please type in your last name.");
    return;
  }

  var country = document.getElementById("country").value;
  if (country == "") {
    alert("Please select your country.");
    return;
  }

  var email = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[4];
  var res = ValidateEmail(email);
  if (!res) {
    return;
  }

  var reg_type = document.getElementById("reg_type").value;
  if ((reg_type == "ACM") | (reg_type == "AST")) {
    var memnum = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[5];
    if (memnum.value == "") {
      alert("Please type in your ACM member number.");
      return;
    }
  }

  var tb = document.getElementById("paymethod").getElementsByTagName("tbody");
  var paymethod = tb[0].getElementsByTagName("select")[0].value;
  if (paymethod == "") {
    alert("Please select a payment method.");
	  return;
  } 
  
  if (paymethod == "KG") {
    payment_kgmob(); // domestic
  } else {
    payment_eximbay(); // 해외 결제
  }
}

function ACM_member_number(){
  var reg_type = document.getElementById("reg_type").value;
  if ((reg_type == "ACM") | (reg_type == "AST")) {
    document.getElementById('ACM_mem_num').innerHTML = "<td>ACM Member Number *</td><td><input type='text' required></td><td> </td>";
  } else {
    document.getElementById('ACM_mem_num').innerHTML = "<td> </td><td> </td><td> </td>";
  }
}

function ValidateRequired(){
  All_pass = true
  required_form = ['firstname', 'lastname', 'email', 'organization']
  for (var k=0; k<required_form.length; k++){
    for (var l=0; l<document.getElementsByClassName(required_form[k]).length; l++){
      if ((document.getElementsByClassName(required_form[k])[l].value.length>0) && All_pass){
        All_pass = true
      }else{
        All_pass = false
      }
    }
  }
  //alert(document.getElementById('hidden').innerText);
  return All_pass
}

function ValidateEmail(email) {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)) {
    var form = document.createElement("form");
    document.documentElement.appendChild(form);
    form.setAttribute("target", "hiddenifr");
    form.setAttribute("charset", "UTF-8");
    form.setAttribute("method", "Post");
    form.setAttribute("action", "check_email.php");

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "email_"+email.value.replace("@","_"));
    hiddenField.setAttribute("value", email.value);
    form.appendChild(hiddenField);
    form.submit();
  } else {
    alert("Email address is invalid.")
    email.value = "";  
    return false;
  }

  if (email.value=='') {
    return false;
  } else {
    return true;
  } 
}

function ValidateDomesticEmail(email) {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)) {
    var form = document.createElement("form");
    document.documentElement.appendChild(form);
    form.setAttribute("target", "hiddenifr");
    form.setAttribute("charset", "UTF-8");
    form.setAttribute("method", "Post");
    form.setAttribute("action", "check_domestic_email.php");

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "email_"+email.value.replace("@","_"));
    hiddenField.setAttribute("value", email.value);
    form.appendChild(hiddenField);
    form.submit();
  } else {
    alert("Email address is invalid.")
    email.value = "";  
    return false;
  }

  if (email.value=='') {
    return false;
  } else {
    return true;
  } 
}
