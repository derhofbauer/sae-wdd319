PHP Rezept für neues Feature => Registrierung

Überlegungen wie mans aufbaut:

1. Views
    1. View für Registrierungsformular
    2. View für Erfolgsmeldung
2. Route anlegen
    1. /sign-up => AuthController.signupForm
    2. /do-sign-up => AuthController.signup
    3. /sign-up/success => AuthController.signupSuccess
3. im AuthController die Methoden anlegen
    1. signupForm
    2. signup
    3. signupSuccess
4. Model anlegen oder vorhandenes verwenden
    1. User Model



Loslegen:
1. Controller öffnen oder anlegen => AuthController gibts schon, die Funktionen fehler aber noch
2. Funktionen für signupForm anlegen (Route: /sign-up => AuthController.signupForm)
    1. kopieren aus login wo überprüft wird ob man eingelogged ist
3. View anlegen für Registrierungs-Formular (ähnlich wie Login-Formular) => signup.view.php und dort das Formular html-Zeug einbauen
4. im header.php einen Navigationspunkt hinzufügen
5. signup Methode wo Daten übergeben werden
    1. wieder im AuthController wo funktion signup erstellt wird (Route: /do-sign-up => AuthController.signup)
    2. welche Daten kriegen wir? 
        1. Daten im Formular eingeben und in der Funktion var_dump($_POST) eingeben um Formulareingaben auszugeben
    3. Eingaben validieren
        1. Validator verwenden
    4. Fehler setzen (get errors) und in die Session setzen und redirect zum Registrierungs-Formular wo Fehler ausgegeben werden und anschließend wieder aus Session gelöscht werden
    5. baseurl laden 
    6. beim nächsten mal: Account anlegen