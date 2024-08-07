var script = document.createElement('script');
script.src = 'eximbay_approval.js';
document.head.appendChild(script);

var script = document.createElement('script');
script.src = 'kgmob_approval.js';
document.head.appendChild(script);

document.getElementById('author_registration').addEventListener('change', calculateTotalFee);
document.getElementById('reg_type').addEventListener('change', calculateTotalFee);
document.getElementById('over_page').addEventListener('change', calculateTotalFee);
document.getElementById('reception').addEventListener('change', calculateTotalFee);
document.getElementById('banquet').addEventListener('change', calculateTotalFee);

window.onload = calculateTotalFee;

// AOE offset
const aoeOffset = -12 * 60 * 60 * 1000;

// Get AOE time
const now = new Date();
const currentAOETime = new Date(now.getTime() + aoeOffset);
const currentTime = currentAOETime.getTime();

// Target AOE time
const targetDateUTCForGeneral = new Date(Date.UTC(2024, 6, 21, 0, 0, 0, 0));
const targetAOETimeForGeneral = new Date(targetDateUTCForGeneral.getTime() + aoeOffset);
const switchTimeForGeneral = targetAOETimeForGeneral.getTime();

const targetDateUTCForAuthor = new Date(Date.UTC(2024, 6, 23, 0, 0, 0, 0));
const targetAOETimeForAuthor = new Date(targetDateUTCForAuthor.getTime() + aoeOffset);
const switchTimeForAuthor = targetAOETimeForAuthor.getTime();

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

  var email = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[5];
  var res = ValidateEmail(email);
  if (!res) {
    return;
  }

  const regType = document.getElementById('reg_type');
  var regTypeStr =  regType.options[regType.selectedIndex].value;
  if ((regTypeStr == "IEEE") | (regTypeStr == "IEEE_STUDENT") | (regTypeStr == "LIFE")) {
    var memnum = document.getElementById('ieee_num'); 
    if (memnum.value == "") {
      alert("Please type in your IEEE member number.");
      return;
    }
  }

  const authType = document.getElementById('author_registration');
  var authTypeStr =  authType.options[authType.selectedIndex].value;
  if ((authTypeStr == "yes")) {
    var title = document.getElementById('manuscript_title_test'); 
    if (title.value == "") {
      alert("Please type in your Manuscript Title.");
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
  var regType = document.getElementById('reg_type');
  var ieeeNumber = document.getElementById('IEEE_mem_num');

  console.log(currentTime);
  console.log(switchTimeForAuthor);
  console.log(switchTimeForGeneral);

  if (registration === 'no') {
      manuscript.style.display = 'none';
      overPage.style.display = 'none';
      if (currentTime >= switchTimeForGeneral) {
        if(document.getElementById('total_fee')){
          // for non-author
          // for international registration & late registration
          regType.innerHTML = `
              <option value="IEEE">General (IEEE Member) : USD 700</option>
              <option value="NON">General (Non IEEE Member) : USD 840</option>
              <option value="IEEE_STUDENT">Student (IEEE Member) : USD 490</option>
              <option value="NST">Student (Non IEEE Member) : USD 590</option>
              <option value="LIFE">Life Member : USD 385</option>
          `;
        }
        else{
          // for non-author
          // for domestic registration & late registration
          regType.innerHTML = `
              <option value="IEEE">General (IEEE Member) : KRW 940,000</option>
              <option value="NON">General (Non IEEE Member) : KRW 1,130,000</option>
              <option value="IEEE_STUDENT">Student (IEEE Member) : KRW 660,000</option>
              <option value="NST">Student (Non IEEE Member) : KRW 790,000</option>
              <option value="LIFE">Life Member : KRW 510,000</option>
          `;
        }
      } else {
        if(document.getElementById('total_fee')){
          // for non-author
          // for international registration & early registration
          regType.innerHTML = `
              <option value="IEEE">General (IEEE Member) : USD 600</option>
              <option value="NON">General (Non IEEE Member) : USD 720</option>
              <option value="IEEE_STUDENT">Student (IEEE Member) : USD 420</option>
              <option value="NST">Student (Non IEEE Member) : USD 505</option>
              <option value="LIFE">Life Member : USD 330</option>
          `;
        }
        else {
          // for non-author
          // for domestic registration & early registration
          regType.innerHTML = `
              <option value="IEEE">General (IEEE Member) :  KRW 810,000</option>
              <option value="NON">General (Non IEEE Member) :  KRW 970,000</option>
              <option value="IEEE_STUDENT">Student (IEEE Member) :  KRW 560,000</option>
              <option value="NST">Student (Non IEEE Member) :  KRW 680,000</option>
              <option value="LIFE">Life Member :  KRW 440,000</option>
          `;
        }
      }
  } else {
      manuscript.style.display = '';
      overPage.style.display = '';
      ieeeNumber.style.display = '';
      if (currentTime >= switchTimeForAuthor) {
        if(document.getElementById('total_fee')){
          // for author
          // for international registration & late registration
          regType.innerHTML = `
              <option value="IEEE">General (IEEE Member) : USD 700</option>
              <option value="NON">General (Non IEEE Member) : USD 840</option>
          `;
        }
        else {
          // for author
          // for domestic registration & late registration
          regType.innerHTML = `
              <option value="IEEE">General (IEEE Member) : KRW 940,000</option>
              <option value="NON">General (Non IEEE Member) : KRW 1,130,000</option>
          `;
        }
      } else {
        if(document.getElementById('total_fee')){
          // for author
          // for international registration & early registration
          regType.innerHTML = `
              <option value="IEEE">General (IEEE Member) : USD 600</option>
              <option value="NON">General (Non IEEE Member) : USD 720</option>
          `;
        }
        else {
          // for author
          // for domestic registration & early registration
          regType.innerHTML = `
              <option value="IEEE">General (IEEE Member) : KRW 810,000</option>
              <option value="NON">General (Non IEEE Member) : KRW 970,000</option>
          `;
        }
      }
  }
}

function toggleIEEEOptions() {
  var regType = document.getElementById('reg_type').value;
  var ieeeNumber = document.getElementById('IEEE_mem_num');

  if (regType.includes('NON') || regType.includes('NST')) {
      ieeeNumber.style.display = 'none';
  } else {
      ieeeNumber.style.display = '';
  }
}

function calculateTotalFee() {
  const authorRegistrationSelect = document.getElementById('author_registration');
  const authorRegistration = authorRegistrationSelect.options[authorRegistrationSelect.selectedIndex].value;
  var registrationType = document.getElementById('reg_type').value;
  if (authorRegistration === 'yes') {
    const page = document.getElementById('over_page');
    var overPageLength =  Number(page.options[page.selectedIndex].value);
  }
  else {
    var overPageLength = 0;
  }
  const reception = document.getElementById('reception');
  var extraReceptionTickets =  reception.options[reception.selectedIndex].value;
  const banquet = document.getElementById('banquet');
  var extraBanquetTickets =  reception.options[banquet.selectedIndex].value;

  var baseFee = 0;
  if (authorRegistration === 'yes') {
    if (document.getElementById('total_fee')) {
      if (currentTime >= switchTimeForAuthor) {
          switch(registrationType) {
            case 'IEEE': baseFee = 700; break;
            case 'NON': baseFee = 840; break;
          }
      } else {
          switch(registrationType) {
            case 'IEEE': baseFee = 600; break;
            case 'NON': baseFee = 720; break;
          }
      }
    } else {
      if (currentTime >= switchTimeForAuthor) {
          switch(registrationType) {
            case 'IEEE': baseFee = 940000; break;
            case 'NON': baseFee = 1130000; break;
          }
      } else {
          switch(registrationType) {
            case 'IEEE': baseFee = 810000; break;
            case 'NON': baseFee = 970000; break;
          }
      }
    }
  } else {
    if (document.getElementById('total_fee')) {
      if (currentTime >= switchTimeForGeneral) {
          switch(registrationType) {
            case 'IEEE': baseFee = 700; break;
            case 'NON': baseFee = 840; break;
            case 'IEEE_STUDENT': baseFee = 490; break;
            case 'NST': baseFee = 590; break;
            case 'LIFE': baseFee = 385; break;
          }
      } else {
          switch(registrationType) {
            case 'IEEE': baseFee = 600; break;
            case 'NON': baseFee = 720; break;
            case 'IEEE_STUDENT': baseFee = 420; break;
            case 'NST': baseFee = 505; break;
            case 'LIFE': baseFee = 330; break;
          }
      }
    } else {
      if (currentTime >= switchTimeForGeneral) {
          switch(registrationType) {
            case 'IEEE': baseFee = 940000; break;
            case 'NON': baseFee = 1130000; break;
            case 'IEEE_STUDENT': baseFee = 660000; break;
            case 'NST': baseFee = 790000; break;
            case 'LIFE': baseFee = 510000; break;
          }
      } else {
          switch(registrationType) {
            case 'IEEE': baseFee = 810000; break;
            case 'NON': baseFee = 970000; break;
            case 'IEEE_STUDENT': baseFee = 560000; break;
            case 'NST': baseFee = 680000; break;
            case 'LIFE': baseFee = 440000; break;
          }
      }
    }
  }
  if (document.getElementById('total_fee')) {
    var totalFee = baseFee
    + (parseInt(overPageLength) * 100)
    + (parseInt(extraReceptionTickets) * 50)
    + (parseInt(extraBanquetTickets) * 65);
    document.getElementById('total_fee').textContent = 'USD ' + totalFee;
  }
  else {
    var totalFee = baseFee
    + (parseInt(overPageLength) * 135000)
    + (parseInt(extraReceptionTickets) * 67000)
    + (parseInt(extraBanquetTickets) * 87000);
    totalFee = totalFee.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    document.getElementById('total_fee_domestic').textContent = 'KRW ' + totalFee;
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
    form.setAttribute("action", "https://rtcsa2024.store/check_email.php");

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
    fetch('https://rtcsa2024.store/check_email.php', {
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
    form.setAttribute("action", "https://rtcsa2024.store/check_domestic_email.php");

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
    fetch('https://rtcsa2024.store/check_domestic_email.php', {
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

