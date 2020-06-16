# MVC Framework

## ToDos / Features

+ [x] Routing: `localhost:8080/mvc/shop/products/{id}` => `localhost:8080/mvc/shop/products/42` => `localhost:8080/mvc/index.php?path=/shop/products/42`
+ [x] Database Abstraction
+ [x] Templating
+ [x] Emailing
+ [ ] Middlewares
+ [x] Validators

## Folders

+ `/app`: App, die mit dem MVC Framework gebaut wird
+ `/config`
+ `/core`: MVC-Framework Files
+ `/public`: CSS, JS, Bilder, etc.
+ `/resources`: Views + CSS/JS+Rohdaten (LESS, Sass, Vue.js, React, ...)
+ `/storage`: Uploads, Temporäre Dateien etc.

## Composer

Dieses MVC verwendet Composer um die Mpdf Library zu installieren. Um Composer zu installieren, folgt bitte der offiziellen Anleitung: https://getcomposer.org/download/
Beachtet dabei, dass ihr das `composer.phar` File in den selben Ordner wie das `composer.json` File speichert.

Im `composer.json` File ist definiert, welche Pakete installiert werden sollen. Wenn ihr also alle Abhängigkeiten installieren wollt, dann müsst ihr im Terminal in dem Ordner, in dem das `composer.phar` File liegt den Befehl `php composer.phar install` ausführen und alle Abhängigkeiten sollten installiert werden.
