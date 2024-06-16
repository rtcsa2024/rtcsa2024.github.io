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
  if ((reg_type == "IEEE") | (reg_type == "IEEE_STUDENT")) {
    var memnum = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[5];
    if (memnum.value == "") {
      alert("Please type in your IEEE member number.");
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

function toggleAuthorOptions() {
  var registration = document.getElementById('author_registration').value;
  var manuscript = document.getElementById('manuscript_title');
  var overPage = document.getElementById('over_page_length');
  var regType = document.getElementById('registration_type');

  if (registration === 'no') {
      manuscript.style.display = 'none';
      overPage.style.display = 'none';
      regType.innerHTML = `
          <option value="General (IEEE Member)">General (IEEE Member)</option>
          <option value="General (Non IEEE Member)">General (Non IEEE Member)</option>
          <option value="Student (IEEE Member)">Student (IEEE Member)</option>
          <option value="Student (Non IEEE Member)">Student (Non IEEE Member)</option>
      `;
  } else {
      manuscript.style.display = '';
      overPage.style.display = '';
      regType.innerHTML = `
          <option value="General (IEEE Member)">General (IEEE Member)</option>
          <option value="General (Non IEEE Member)">General (Non IEEE Member)</option>
      `;
  }
}

function toggleIEEEOptions() {
  var regType = document.getElementById('registration_type').value;
  var ieeeNumber = document.getElementById('ieee_member_number');

  if (regType.includes('Non IEEE Member')) {
      ieeeNumber.style.display = 'none';
  } else {
      ieeeNumber.style.display = '';
  }
}


function IEEE_member_number(){
  var reg_type = document.getElementById("reg_type").value;
  if ((reg_type == "IEEE") | (reg_type == "IEEE_STUDENT") | (reg_type == "LIFE")) {
    document.getElementById('IEEE_mem_num').innerHTML = "<td>IEEE Member Number *</td><td><input type='text' required></td><td> </td>";
  } else {
    document.getElementById('IEEE_mem_num').innerHTML = "<td> </td><td> </td><td> </td>";
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
    form.setAttribute("method", "post");
    form.setAttribute("action", "http://54.160.128.164/check_email.php");

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "email_"+email.value.replace("@","_"));
    hiddenField.setAttribute("value", email.value);
    form.appendChild(hiddenField);
    
    const formData = new FormData(form);

    // Convert FormData to an object that can be iterated over
    const plainObject = {};
    formData.forEach(function(value, key){
        plainObject[key] = value;
    });

    // Now create URLSearchParams from the iterable object
    const searchParams = new URLSearchParams(Object.entries(plainObject));

    // Fetch example
    fetch('http://54.160.128.164/check_email.php', {
      method: 'POST',
      body: searchParams
    })
    .then(response => response.json())
    .then(data => {
      if (data.status == "OK") {
        console.log("This email address is not registered yet [check_email]");
      }
      else {
        alert("This email address is already registered.");
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.textContent = "<script>parent.document.getElementById('personal_infos_tbody').getElementsByTagName('input')[4].value = ''</script> <script>alert(`The email address is already registered. If you want to change your previous registration,please contact to the web chair.`)</script>";
        document.body.appendChild(script);
        email.value = "";
      }
    })
    .catch(error => console.error('Error:', error));
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
    form.setAttribute("action", "http://54.160.128.164/check_domestic_email.php");

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "email_"+email.value.replace("@","_"));
    hiddenField.setAttribute("value", email.value);
    form.appendChild(hiddenField);

    const formData = new FormData(form);

    // Convert FormData to an object that can be iterated over
    const plainObject = {};
    formData.forEach(function(value, key){
        plainObject[key] = value;
    });

    // Now create URLSearchParams from the iterable object
    const searchParams = new URLSearchParams(Object.entries(plainObject));

    // Fetch example
    fetch('http://54.160.128.164/check_domestic_email.php', {
      method: 'POST',
      body: searchParams
    })
    .then(response => response.json())
    .then(data => {
      if (data.status == "OK") {
        console.log("This email address is not registered yet [check_domestic_email]");
      }
      else {
        alert("This email address is already registered.");
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.textContent = "<script>parent.document.getElementById('personal_infos_tbody').getElementsByTagName('input')[4].value = ''</script> <script>alert(`The email address is already registered. If you want to change your previous registration,please contact to the web chair.`)</script>";
        document.body.appendChild(script);
        email.value = "";
      }
    })
    .catch(error => console.error('Error:', error));

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
