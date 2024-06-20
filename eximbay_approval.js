function payment_eximbay() {
  var form = createForm();
  const infos = document.getElementById('personal_infos').getElementsByTagName('tbody')[0].getElementsByTagName('tr');

  const authorRegSelect = document.getElementById('author_registration');
  const authorReg = authorRegSelect.options[authorRegSelect.selectedIndex].value;
  
  var overPageLength = "0";
  var manuTitle = "0";
  var ieee_num = -1;
  if (authorReg === 'yes') {
    const overPageSelect = document.getElementById('over_page');
    overPageLength = overPageSelect.options[overPageSelect.selectedIndex].value;
    console.log(overPageLength);
    manuTitle = document.getElementById('manuscript_title_test').value;
  }
  console.log(overPageLength);
  const regTypeSelect = document.getElementById('reg_type');
  const reg_type = regTypeSelect.options[regTypeSelect.selectedIndex].value;
  if (reg_type === 'IEEE' || reg_type === 'IEEE_STUDENT' || reg_type === 'LIFE') {
    ieee_num = document.getElementById('ieee_num').value;
  }

  const receptionSelect = document.getElementById('reception');
  const reception = receptionSelect.options[receptionSelect.selectedIndex].value;

  const banquetSelect = document.getElementById('banquet');
  const banquet = banquetSelect.options[banquetSelect.selectedIndex].value;

  const totalFee = document.getElementById('total_fee').innerText.replace('USD ', '').trim();

  const countrySelect = document.getElementById('country');
  const country = countrySelect.options[countrySelect.selectedIndex].value;

  const org = document.getElementById('affiliation').value;
  const job = document.getElementById('job_title').value;

  const formData = {
    openapi_server: 'https://54.160.128.164/eximbay_openapi.php',
    transaction_type: 'PAYMENT',
    charset: 'UTF-8',
    status_url: 'https://54.160.128.164/eximbay_status.php',
    return_url: 'https://54.160.128.164/eximbay_return.php',
    rescode: '',
    resmsg: '',
    mid: 'C9D8F1129C',
    currency: 'USD',
    amount: totalFee,
    authorRegistration: authorReg,
    registertype: reg_type,
    overPageLength: overPageLength,
    manuscriptTitle: manuTitle,
    ieeeNum: ieee_num,
    extraReceptionTickets: reception,
    extraBanquetTickets: banquet,
    jobTitle: job,
    country: country,
    affiliation: org,
    ieee_num: ieee_num,
    param3: `ieee_type=${reg_type}&country=${country}&affiliation=${org}&ieee_num=${ieee_num}`,
    name: getFullName(),
    email: getInputValue('personal_infos_tbody', 5),
    lang: 'EN',
    paymethod: getSelectedValue('paymethod', 0),
    order_id: '0'
  };

  Object.keys(formData).forEach(key => appendHiddenInput(form, key, formData[key]));
  document.documentElement.appendChild(form);
  submit_eximbay(form);
}

function createForm() {
  var form = document.createElement("form");
  form.setAttribute("charset", "UTF-8");
  form.setAttribute("name", "regForm");
  form.setAttribute("method", "post");
  form.setAttribute("action", "http://54.160.128.164/eximbay_openapi.php");
  return form;
}

function getAdditionalParams(reg_type, country, org, ieee_num) {
  return `ieee_type=${reg_type}&country=${country}&affiliation=${org}&ieee_num=${ieee_num}`;
}

function appendHiddenInput(form, name, value) {
  var input = document.createElement("input");
  input.setAttribute("type", "hidden");
  input.setAttribute("name", name);
  input.setAttribute("value", value || '');
  form.appendChild(input);
}

function getFullName() {
  var firstname = getInputValue('personal_infos_tbody', 0);
  var middlename = getInputValue('personal_infos_tbody', 1);
  var lastname = getInputValue('personal_infos_tbody', 2);
  return middlename ? `${firstname} ${middlename} ${lastname}`.slice(0, 49) : `${firstname} ${lastname}`.slice(0, 49);
}

function getInputValue(parentId, index) {
  return document.getElementById(parentId).getElementsByTagName('input')[index].value;
}

function getSelectedValue(parentId, index) {
  var select = document.getElementById(parentId).getElementsByTagName("select")[0];
  return select.options[select.selectedIndex].value;
}

function submit_eximbay(form) {
  console.log(form);
  const formData = new FormData(form);
  console.log(formData);
  fetch(form.action, {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => handleResponse(data, formData))
  .catch(error => console.error('Error:', error));
}

function handleResponse(data, formData) {
  const sendObj = {
    fgkey: data.fgkey,
    payment: {
      transaction_type: formData.get('transaction_type'),
      order_id: formData.get('order_id'),
      currency: formData.get('currency'),
      amount: formData.get('amount'),
      lang: formData.get('lang')
    },
    merchant: { mid: formData.get('mid') },
    buyer: {
      name: formData.get('name'),
      email: formData.get('email')
    },
    url: {
      return_url: formData.get('return_url'),
      status_url: formData.get('status_url')
    }
  };
  EXIMBAY.request_pay(sendObj);
}