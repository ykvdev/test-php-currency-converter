# RingoStat Currency Converter Test Task

## Usage

1. `git clone https://bitbucket.org/atoumus/test_ringostat_currency_converter.git && cd ./test_ringostat_currency_converter`
1. `composer install`
1. Run as a dev env: `php -S 0.0.0.0:8000 -t public ./public/index.php` - errors will showing
1. Or run as a prod env: `ENV_CURRENT=prod php -S 0.0.0.0:8000 -t public ./public/index.php` - errors will not showing
1. Update currencies `./app/console/run update-currency-rates`
1. Go to: http://{your-ip-address}:8000 in browser

## Task Description

Необходимо реализовать сервис конвертации доллара в любую другую валюту. Для примера возьмем в китайские юани. 
Можно ввести 100 в инпут и нажать кнопку "Convert". По итогу получаем "100 долларов = 688 юаней".

Требования:

1. Обязательно использовать composer.
1. Реализовать без фреймворков (symfony, yii2, etc.). Интересно посмотреть как разработчик структурирует свой код.
1. Реализация фронтенда произвольная (jQuery, Angular, React).
1. Необходимо использовать API сервис для конвертации (рэйты нужно брать у стороннего API, не хардкодить их на бекенде).
1. Архитектура должна предусматривать лёгкую смену провайдера рэйтов.

В прием задачи входит:

1. Ссылка на демо.
1. Ссылка в публичный репозиторий для ревью написанного кода.

Примечания:

1. Оцениваться будет качество кода и реализации.
1. Понимаю, что вы не JS разработчик, поэтому и не просим сложной фронтовой части. 
Но базовыми знаниями JS любой девелопер должен обладать.
Нельзя использовать только фреймворки, типа: symfony, yii2. Использовать библиотеки, SDK, 
бандлы, плагины и прочее приветствуется.