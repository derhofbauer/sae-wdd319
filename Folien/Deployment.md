# Deployment

## "klassischen" Webspace

+ PHP+MySQL
+ man teilt sich einen Server mit anderen Leuten (GoDaddy, 1&1, bplaced, easyname, ...)
  + Speicherplatz + CPU + RAM
+ FTP Zugriff (File Transfer Protocol)
    
### Pro/Con

- Apache2.4, PHP7.3, MySQLx.y - Abhängigkeit von Versionen des Hosters
- Symlinks/Softlinks
+ "Managed" Service - wir müssen keine Server Updates machen (Sicherheistpatches, OS, ...)

## Static Hosts (Netlify, ...)

+ quasi Webspace ohne PHP/MySQL
+ React/Vue/SPA

### Pro/Con

- kein serverseitiger Code
+ super schnelle Requests, weil der Server nicht rechnen muss
+ meistens recht günstig

## Container (Heroku, DigitalOcean, AWS, Azure, ...)

+ ~"Abgekapselter Bereich ähnlicher eine Virtual Machine, aber ohne Hypervisor"
+ 1 Service pro Container

### Pro/Con

- Konfiguration ist tricky
- Selbst gebaute Container (bspw. Dockerfile) müssen selbst aktualisiert werden (Sicherheitspatches, etc.)
- komplexe Probleme, weil Container stateless sein sollten (DB, File Storage)
+ Exakt dieselben Versionen & Config in DEV & PROD
+ Microservice-Architekturen
+ Management des physischen Servers fällt weg
+ Starten seeeehr schnell --> skalierbar!

## Dedicated Server / Virtuelle Server

+ Physischer Server in irgendeinem Rechenzentrum nur für uns
+ ROOT ZUGRIFF (wir dürfen alles und können alles)

### Pro/Con

- wir sind zuständig für die OS Updates, Patches, etc. (ALLES! :( )
+ Volle Flexibilität!
