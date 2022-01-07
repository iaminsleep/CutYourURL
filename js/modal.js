const popup = document.querySelector('.popup');
const openModal = document.querySelector('.btn-side');
const closeModal = document.querySelector('.popup-close');

const modalDescription = popup.querySelector('.description');
const title = popup.querySelector('h2');

let pathname = window.location.pathname;
switch(pathname) {
  case "/admin.php":
    title.textContent = "Памятка для админа";
    modalDescription.innerHTML = "Добро пожаловать на главную страницу! Отсюда начинается ваше <b>управление</b> сайтом. </br></br><b>Выберите</b> один из двух разделов, чтобы продолжить.</br></br>Подробная информация о каждом разделе будет доступна после <b>перехода</b> на страницу.";
    break;
  case "/admin/manage_links.php":
    title.textContent = "Управление ссылками";
    modalDescription.innerHTML = "Здесь происходит управление <b>всеми</b> ссылками, которые создают пользователи.</br></br>Вы можете <b>удалить</b> или <b>отредактировать</b> ссылку, если она нарушает политику вашего сайта, или же ведёт на вредоносные и запрещённые ресурсы.</br></br>Также, к каждой ссылке привязан <b>профиль</b> пользователя, перейдя в который вы сможете узнать более детальную информацию о нём и <b>наказать</b> в случае необходимости.";
      break;
  case "/admin/manage_users.php":
    title.textContent = "Управление пользователями";
    modalDescription.innerHTML = "Здесь осуществляется управление <b>пользователями</b> которые зарегистрированы на вашем сайте. </br></br>Отсюда вы можете перейти в профиль <b>любого</b> пользователя и управлять его ссылками. </br></br>Удалите <b>аватар</b> пользователя, если он нарушает политику сайта. </br></br>И наконец, <b>удалите самого пользователя</b>, если он нарушил правила несколько раз (например, трижды).";
      break;
}

const modalHandler = function() {
  popup.classList.toggle('visible');
}

openModal.addEventListener('click', modalHandler);

closeModal.addEventListener('click', modalHandler);