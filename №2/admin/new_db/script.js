function toggleAdditionalInfo(infoId) {
  var additionalInfo = document.getElementById(infoId);
  if (additionalInfo.style.display === "none") {
    additionalInfo.style.display = "block";
  } else {
    additionalInfo.style.display = "none";
  }
}

//скрипт на переход на другие страницы
function goToPage(page) {
  window.location.href = page;
 }

//всплывающее окно
function showPhoneNumber(name, phoneNumber) {
  alert(`Номер телефона ${name}: ${phoneNumber}`);
}

function showPhoneNumber(name, phoneNumber) {
  var popupOverlay = document.getElementById('popupOverlay');
  var popup = document.getElementById('popup');
  var popupTitle = document.getElementById('popupTitle');
  var popupPhoneNumber = document.getElementById('popupPhoneNumber');

  popupTitle.textContent = name;
  popupPhoneNumber.textContent = phoneNumber;

  popupOverlay.style.display = 'block';
  popupOverlay.style.opacity = '0';

  setTimeout(function() {
    popupOverlay.style.opacity = '1';
    popup.style.transform = 'translateY(0)';
  }, 10);
}

function closePopup() {
  var popupOverlay = document.getElementById('popupOverlay');
  var popup = document.getElementById('popup');

  popup.style.transform = 'translateY(-100%)';
  popupOverlay.style.opacity = '0';

  setTimeout(function() {
    popupOverlay.style.display = 'none';
  }, 300);

}


