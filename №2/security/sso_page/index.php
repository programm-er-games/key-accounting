<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users list</title>
  <!--подключенные стили и скрипты-->
  <link rel="stylesheet" href="style.css">
  <script src="script.js"></script>

</head>

<body>
  <!--подключенные стили и скрипты-->


  <!--кнопочки-->
  <section>


    <div class="box">

      <div class="heder">
        <h3>Calls</h3>
        <div class="list" onclick="goToPage('../start_page/index.html')">
          <h4>Вернуться</h4>
        </div>
      </div>

      <?php
      require "../../db_v2.php";
      $main_conn = new Db("C:\\Windows.old\\Users\\User\\Documents\\GitHub\\key-accounting\\KA.db");
      $main_conn->start(["security" => ["name" => "TEXT NOT NULL", "surname" => "TEXT", "patronymic" => "TEXT NOT NULL", "email" => "TEXT NOT NULL UNIQUE", "password" => "TEXT NOT NULL UNIQUE"]]);
      $security = $main_conn->get("security", ["name", "surname"]);
      if (is_string($security) || $security === false) {
        echo $security === false ? "Ничего не найдено!" : $security;
      } else if (is_array($security)) {
        // var_dump($security);
        $i = 0;
        foreach ($security as $value) {
          echo '<div class="list" onclick="showPhoneNumber(';
          echo "'user $i', '" . $value["name"] . " " . $value["surname"] . "', 'images/key.png'";
          echo ')">
          <div class="imgBx">
            <img src="images/user.png" alt="">
          </div>
          <div class="content">
            <h2 class="rank"><small>#</small>' . $i++ . '</h2>
            <h4>ФИО есть</h4>
            <p>Место поста охранника есть</p>
          </div>
        </div>
        <div class="popup-overlay" id="popupOverlay" onclick="closePopup()">
          <div class="popup" id="popup">
            <img src="images/id.gif">
            <h3 id="popupTitle"></h3>
            <p id="popupPhoneNumber"></p>
            <button onclick="sign_in(' . "'" . $value["name"] . "'" . ')">Войти</button>
          </div>
        </div>';
        }
      }
      ?>

      <!-- <div class="list" onclick="showPhoneNumber('user 0', 'ФИО', 'images/key.png')">
        <div class="imgBx">
          <img src="images/user.png" alt="">
        </div>
        <div class="content">
          <h2 class="rank"><small>#</small>1</h2>
          <h4>ФИО</h4>
          <p>Место поста охранника</p>
        </div>
      </div>

      <div class="popup-overlay" id="popupOverlay" onclick="closePopup()">
        <div class="popup" id="popup">
          <img src="images/id.gif">
          <h3 id="popupTitle"></h3>
          <p id="popupPhoneNumber"></p>
          <button onclick="closePopup()">Войти</button>
        </div>
      </div> -->

    </div>

  </section>
  <script>
    function sign_in(name) {
      location.href = "../start_page/index.html";
      document.cookie = "name=" + name + ";path=/";
    }
  </script>

</body>

</html>