<div id="top"></div>



<br />
<div align="center">



  <h3 align="center">
    Домашний проект для удобного упорядочивания прослушанной музыки.
    <br />
    <br />

  </h3>
</div>


<details>
  <summary>Содержание</summary>
  <ol>
    <li>
      <a href="#about-the-project">Что это и зачем это нужно?</a>
    </li>
        <li><a href="#technologies">Используемые технологии</a></li>
        <li><a href="#requirements">Технические требования</a></li>
    <li><a href="#installation">Установка</a></li>
    <li><a href="#usage">Использование</a></li>
    <li><a href="#license">Лицензия</a></li>
    <li><a href="#future">Будущее</a></li>
    <li><a href="#contact">Обратная связь</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## Что это и зачем это нужно?
<div id="about-the-project">
Проект возник из двух потребностей. 

1. В какой-то момент времени у меня появилась идея вести список всех прослушанных мною музыкальных альбомов.
2. Со временем я заметил, что те альбомы, которые несколько лет назад я считал хорошими, сейчас такого впечатления не производят. 
И наоборот, вещи, которые я считал довольно блеклыми, сейчас воспринимаются совершенно иначе.
Так появилось понимание, что необходимо записывать впечатления об альбомах, чтобы потом их можно было сравнивать.
<br><br>
Изначально все это писалось в обычный excel файл, однако со временем этого стало недостаточно. 
Возникла потребность использования какого-либо сервиса. К сожалению, таких сервисов не оказалось. 
Так появилась идея создать проект для собственных нужд, в котором можно было бы удобно создавать и редактировать записи, а так же осуществлять их фильтрацию по определенным параметрам. 
На текущий момент реализованы следующие возможности:


* Создание, удаление, изменение, фильтрация альбомов.
* Создание, удаление, изменение записей впечатлений об альбоме.
* Просмотр записей привязанных к определенному альбому.
* Просмотр альбомов выпущенных определенным артистом.

<p align="right">(<a href="#top">наверх</a>)</p>
</div>

<div id="technologies">

###Используемые технологии

Фреймворки используемые в данном проекте


* [Vue.js](https://vuejs.org/)
* [Laravel](https://laravel.com)
* [Bootstrap](https://getbootstrap.com)

Взаимодействие происходит по rest api
<p align="right">(<a href="#top">наверх</a>)</p>
</div>



<div id="installation">

### Установка

Для установки необходимо иметь PHP >= 7.3.0. Чтобы запустить проект, необходимо создать базу данных

1. Клонировать репозиторий
   ```sh
   git clone https://github.com/shipilov484/portfolio.git
   ```
2. В `.env` файле ввести учетные данные вашей БД.
   ```sh
    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=dairy
    DB_USERNAME=
    DB_PASSWORD=
   ```
3. Установить composer, если это не сделано
    ```sh
   composer install
   ```
4. Сгенерировать ключ приложения
    ```sh
    php artisan key:generate
    ```

5. Выполнить миграции
   ```sh
   php artisan migrate
   ```

   
6. При желании можно заполнить таблицы тестовыми данными 
      ```sh
      php artisan db:seed
      ```
   
7. Запустить
   ```sh
   php artisan serve
   ```

<p align="right">(<a href="#top">наверх</a>)</p>
</div>


<div id="usage">

## Использование

Примеры применения проекта. \
Страница со всеми альбомами
<img src="preview_images/album list.png">

Создание записи об альбоме.

<img src="preview_images/create album.png">


Поиск альбомов с определенными фильтрами.

<img src="preview_images/filter album.png">

Удаление альбома.

<img src="preview_images/delete album.png">


Создание записи с впечатлением.

<img src="preview_images/create dairy.png">

Прикрепление альбома к записи.

<img src="preview_images/attach album.png">

Страница со всеми записями об альбоме

<img src="preview_images/album page.png">

Страница исполнителя

<img src="preview_images/artist page.png">

<p align="right">(<a href="#top">наверх</a>)</p>

</div>






<div id="license">
<!-- LICENSE -->

## License

Distributed under the MIT 

<p align="right">(<a href="#top">наверх</a>)</p>
</div>
<div id="future">

## Будущее
 В будущем планируется реализация следующих возможностей:
* добавление фильтрации для раздела впечатлений
* группировка записей с впечатлениями по временам года
* добавление различных графиков
* экспорт данных в excel
* изменение дизайна
<p align="right">(<a href="#top">наверх</a>)</p>
</div>



<div id="contact">
<!-- CONTACT -->
## Обратная связь

Дмитрий Шипилов - email - shipilov4842000@gmail.com


<p align="right">(<a href="#top">наверх</a>)</p>
</div>
