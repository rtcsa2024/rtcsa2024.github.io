function payment_eximbay() {
  var form = document.createElement("form"); // 서버로 입력한 데이터를 보내기 위해서
  document.documentElement.appendChild(form) // html 에 추가
  form.setAttribute("charset", "UTF-8");
  form.setAttribute("name", "regForm");
  form.setAttribute("method", "post"); // post 방식 
  form.setAttribute("action", "http://54.160.128.164/eximbay_openapi.php"); // 요청 보낼 주소

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "ver");
  hiddenField.setAttribute("value", "230");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "transaction_type");
  hiddenField.setAttribute("value", "PAYMENT");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "charset");
  hiddenField.setAttribute("value", "UTF-8");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "status_url");
  hiddenField.setAttribute("value", "http://54.160.128.164/eximbay_status.php");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "return_url");
  hiddenField.setAttribute("value", "http://54.160.128.164/eximbay_return.php");
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
  // hiddenField.setAttribute("value", "1849705C64"); // for test
  hiddenField.setAttribute("value", "C9D8F1129C"); // for service
  form.appendChild(hiddenField);
 
  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "ref");
  hiddenField.setAttribute("value", "KIISE(rtcsa2024)");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "currency");
  hiddenField.setAttribute("value", "USD");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "amount");
  var infos = document.getElementById('personal_infos').getElementsByTagName('tbody'); 
  var country = infos[0].getElementsByTagName('select')[0].value;
  var reg_type = infos[0].getElementsByTagName('select')[1].value;
  var total_price = 0;
  var non_quantity = 0;
  var ieee_quantity = 0;
  var nst_quantity = 0;
  var ieee_student_quantity = 0;
  for (var k=0; k<(infos.length-1); k++){
    if ('IEEE' == infos[k].getElementsByTagName('select')[1].value){
      non_quantity += 1;
      total_price += 600;
    }else if ('NON' == infos[k].getElementsByTagName('select')[1].value){
      ieee_quantity += 1;
      total_price += 720;
    }else if ('IEEE_STUDENT' == infos[k].getElementsByTagName('select')[1].value){
      nst_quantity += 1;
      total_price += 420;
    }else if ('NST' == infos[k].getElementsByTagName('select')[1].value){
      ieee_student_quantity += 1;
      total_price += 505;
    }else if ('LIFE' == infos[k].getElementsByTagName('select')[1].value){
        ieee_student_quantity += 1;
        total_price += 330;
    }else{alert('unknown error in Type'); return; }
  }
  hiddenField.setAttribute("value", total_price);
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "shop");
  hiddenField.setAttribute("value", "KIISE(rtcsa2024)");
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "name");
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
  var others = "ieee_type=" + reg_type + "&";
  var ieee_num = -1;
  others += "country=" + country + "&";
  others += "affiliation=" + org + "&";
  if ((reg_type == "IEEE") | (reg_type == "IEEE_STUDENT")) {
    ieee_num = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[5].value;
  }
  others += "ieee_num=" + ieee_num;
  hiddenField.setAttribute("value", others);
  form.appendChild(hiddenField);
  //alert(others);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "email");
  var email = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[4].value;
  hiddenField.setAttribute("value", email);
  form.appendChild(hiddenField);

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "lang");
  hiddenField.setAttribute("value", "EN");
  form.appendChild(hiddenField);
  

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "paymethod");
  var tb = document.getElementById("paymethod").getElementsByTagName("tbody");
  var paymethod = tb[0].getElementsByTagName("select")[0].value;
  hiddenField.setAttribute("value", paymethod);
  form.appendChild(hiddenField);

  var prod_name = "IEEE RTCSA 2024 Registration"

  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("type", "hidden");
  hiddenField.setAttribute("name", "order_id");
  hiddenField.setAttribute("value", 0);
  form.appendChild(hiddenField);

  submit_eximbay(form);
}

function submit_eximbay(dfm){
  const formData = new FormData(dfm);

  // Convert FormData to an object that can be iterated over
  const plainObject = {};
  formData.forEach(function(value, key){
      plainObject[key] = value;
  });

  // Now create URLSearchParams from the iterable object
  const searchParams = new URLSearchParams(Object.entries(plainObject));

  // Fetch example
  fetch('http://54.160.128.164/eximbay_openapi.php', {
      method: 'POST',
      body: searchParams
  })
  .then(response => response.json())
  .then(data => {
    const sendObj = {
      "fgkey" : "",
      "payment" : {
          "transaction_type" : "",
          "order_id" : "",
          "currency" : "",
          "amount" : "",
          "lang" : ""
      },
      "merchant" : {
          "mid" : ""
      },
      "buyer" : {
          "name" : "",
          "email" : ""
      },
      "url" : {
          "return_url" : "",
          "status_url" : ""
      }
  }
    sendObj.fgkey = data.fgkey;
    sendObj.payment.transaction_type = plainObject['transaction_type'];
    sendObj.payment.order_id = plainObject['order_id'];
    sendObj.payment.currency = plainObject['currency'];
    sendObj.payment.amount = plainObject['amount'];
    sendObj.payment.lang = plainObject['lang'];
    sendObj.merchant.mid = plainObject['mid'];
    sendObj.buyer.name = plainObject['name'];
    sendObj.buyer.email = plainObject['email'];
    sendObj.url.return_url = plainObject['return_url'];
    sendObj.url.status_url = plainObject['status_url']; 
    EXIMBAY.request_pay(sendObj);
  })
  .catch(error => console.error('Error:', error));
}