# Documentation (English)

## Requirements

- At least PHP 5 (tested on PHP 5.2.17)
- Either SQLite exension installed or MySQL Database available

## Getting started

### Installation

1. Copy all content of the package into your webroot
2. Navigate to yourdomain.tld/eagb/install.php
3. You now have to choose between SQLite and MySQL
    - [SQLite](http://sqlite.org/): Make sure your "data" folder inside the eagb folder is writeable (777) and click &lt;Install&gt;.
    - [MySQL](http://mysql.com/): Enter your Server Information and User credentials. Then click &lt;Install&gt;.
4. Finish! You should now see the "Success" page. To check your installation, navigate to yourdomain.tld/demo.php to see the demo page.

NOTE: Default Username and Password for the Adminpage:
User: admin
Password: password

### Integration
_(For basic integration, you can check the demo.php inside your webroot.)_

Basically, you need 3 Things after you installed the guestbook:

1. put `include 'eagb/eagb.php'` at the top of your index.php
2. put `<?php echo eaLoadTheme('standard'); ?>` inside your layout's `&lt;head&gt;` to load the basic styling for the guestbook.
3. A place for the guestbook itself. To ouput it in the desired place, just write `<?php echo $eaGB; ?>` where you want your guestbook.

## Enjoy!

# Dokumentation (Deutsch)

## Anforderungen

- Mindestens PHP 5 (getestet auf PHP 5.2.17)
- Entweder eine installierte SQLite erweiterung oder eine MySQL Datenbank

## Schnellstart

### Installation

1. Kopiere alle Dateien aus dem Archiv in dein Webroot
2. Öffne in deinem Browser die URL deinedomain.de/eagb/install.php
3. Jetzt müssen Sie zwischen SQLite und MySQL wählen
    - [SQLite](http://sqlite.org/): Stellen Sie sicher das das "data" Verzeichnis im eagb Ordner beschreibbar ist (777) und klicken Sie auf &lt;Installieren&gt;.
    - [MySQL](http://mysql.com/): Geben Sie Ihre Serverdaten und MySQL Benutzerdaten ein und klicken Sie auf &lt;Installieren&gt;.
4. Fertig! Jetzt müssten Sie eine "Erfolgs"-seite sehen. Um die Installation zu testen, öffnen Sie die URL deinedomain.de/demo.php um die Demoseite zu öffnen.

NOTIZ: Standard Benutzername und Password für die Adminseite:
Name: admin
Passwort: password

### Einbindung in Ihre Seite
_(Für ein Beispiel der Einbindung, können Sie die Demoseite in Ihrem Webroot studieren.)_

Grundsätzlich müssen Sie 3 Dinge tun um das Gästebuch einzubinden:

1. Fügen Sie `include 'eagb/eagb.php'` an den Anfang Ihrer index.php ein
2. Fügen Sie `<?php echo eaLoadTheme('standard'); ?>` in den `&lt;head&gt;`-Bereich Ihrer Webseite ein um das Basisstyling für das Gästebuch zu laden.
3. Einen Platz für das Gästebuch. Um das Gästebuch auszugeben, schreiben Sie `<?php echo $eaGB; ?>` an die gewünschte Stelle.

## Viel Spaß!
