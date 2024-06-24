function payment_kgmob() {
  const form = createFormKG();

  const personalInfos = document.getElementById('personal_infos').getElementsByTagName('tbody')[0];
  const totalFee = Number(document.getElementById('total_fee_domestic').innerText.replace('KRW ', '').replace(/,/g, "").trim());
  addHiddenField(form, 'Prdtprice', totalFee);
  addHiddenField(form, 'Prdtnm', 'IEEE RTCSA 2024 registration');

  const fullname = getFullName();
  addHiddenField(form, 'buyer', fullname);

  const org = document.getElementById('affiliation').value; //const org = getOrganization() || 'None';
  const countrySelect = document.getElementById('country');
  const country = countrySelect.options[countrySelect.selectedIndex].value; //const country = personalInfos.getElementsByTagName('select')[0].value;

  const authorRegSelect = document.getElementById('author_registration');
  const authorReg = authorRegSelect.options[authorRegSelect.selectedIndex].value;
  
  var overPageLength = "0";
  var manuTitle = "0";
  var ieee_num = -1;
  if (authorReg === "yes") {
    const overPageSelect = document.getElementById('over_page');
    overPageLength = overPageSelect.options[overPageSelect.selectedIndex].value;
    manuTitle = document.getElementById('manuscript_title_test').value;
  }

  const regTypeSelect = document.getElementById('reg_type');
  const reg_type = regTypeSelect.options[regTypeSelect.selectedIndex].value;
  if (reg_type === 'IEEE' || reg_type === 'IEEE_STUDENT' || reg_type === 'LIFE') {
    ieee_num = document.getElementById('ieee_num').value;
  }

  const others = constructOthers(org, country, reg_type);
  addHiddenField(form, 'param3', others);

  const receptionSelect = document.getElementById('reception');
  const reception = receptionSelect.options[receptionSelect.selectedIndex].value;

  const banquetSelect = document.getElementById('banquet');
  const banquet = banquetSelect.options[banquetSelect.selectedIndex].value;
  const job = document.getElementById('job_title').value;
  const dietary = document.getElementById('dietary').value;

  addHiddenField(form, 'affiliation', org);
  addHiddenField(form, 'country', country);
  addHiddenField(form, 'amount', totalFee);
  addHiddenField(form, 'authorRegistration', authorReg);
  addHiddenField(form, 'registertype', reg_type);
  addHiddenField(form, 'overPageLength', overPageLength);
  addHiddenField(form, 'manuscriptTitle', manuTitle);
  addHiddenField(form, 'ieee_type', reg_type);
  addHiddenField(form, 'ieee_num', ieee_num);
  addHiddenField(form, 'extraReceptionTickets', reception);
  addHiddenField(form, 'extraBanquetTickets', banquet);
  addHiddenField(form, 'jobTitle', job);
  addHiddenField(form, 'dietary', dietary);

  const email = getEmail();
  addHiddenField(form, 'email', email);

  const misc = `name=${fullname.slice(0, 49)}&email=${email}&${others}`;
  addHiddenField(form, 'misc', misc);

  console.log(form);
  submit_kgmob(form);
}

function createFormKG() {
  const form = document.createElement('form');
  document.head.appendChild(form);
  form.setAttribute('charset', 'UTF-8');
  form.setAttribute("name", "regForm");
  form.setAttribute('method', 'post');
  form.setAttribute('action', 'https://rtcsa2024.store/kgmob_approval.php');
  return form;
}

function addHiddenField(form, name, value) {
  const hiddenField = document.createElement('input');
  hiddenField.type = 'hidden';
  hiddenField.name = name;
  hiddenField.value = value || '';
  form.appendChild(hiddenField);
}

function getFullName() {
  var firstname = getInputValue('personal_infos_tbody', 0);
  var middlename = getInputValue('personal_infos_tbody', 1);
  var lastname = getInputValue('personal_infos_tbody', 2);
  return middlename ? `${firstname} ${middlename} ${lastname}`.slice(0, 49) : `${firstname} ${lastname}`.slice(0, 49);
}

function getEmail() {
  return getInputValue('personal_infos_tbody', 5);
}

function constructOthers(org, country, reg_type) {
  const ieee_num = (reg_type === "IEEE" || reg_type === "IEEE_STUDENT") ? 
      document.getElementById('personal_infos_tbody').getElementsByTagName('input')[5].value : -1;
  return `ieee_type=${reg_type}&country=${country}&affiliation=${org}&ieee_num=${ieee_num}`;
}

function submit_kgmob(dfm) {
  // async new window 
  setTimeout(function() {
    var email = document.getElementById('personal_infos_tbody').getElementsByTagName('input')[5];
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
