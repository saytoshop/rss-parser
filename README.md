Задача:

Необходимо разработать консольное приложение для парсинга и сохранения новостей в
локальную базу данных. Запуск команды должен осуществляться через cron.

Парсинг

Парсер должен обращаться к RSS странице новостей
http://static.feed.rbc.ru/rbc/logical/footer/news.rss. Каждая новость из ленты должна сохраняться в
локальную базу данных со следующим набором полей:
1. Название
2. Ссылка
3. Краткое описание
4. Дата и время публикации
5. Автор (если указан)
6. Изображение (если есть)

   
Логирование:

   Каждый запрос парсера должен логироваться в базу данных. Информация для логирования:
1. Дата и время
2. Request Method
3. Request URL
4. Response HTTP Code
5. Response Body
   
Требования:
1. Фреймворк Laravel 8 (9).
2. База данных PostgreSQL.
3. Административная панель Orchid.
4. Запуск парсинга осуществляется с помощью Scheduler.
