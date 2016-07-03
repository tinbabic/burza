# README #

Ovo je novo slozeni projekt koji slijedi PHPRO MVC.

Za upoznati se sa tim najbolje je proci MVC predavanja ili proci ovaj tutorijal: https://www.phpro.org/tutorials/Model-View-Controller-MVC.html

## Generalne upute ##

service.class.php je sveokupna klasa koja komunicira sa bazom, za opce potrebe mozete ignorirati authservice.class.php

Skripte za updejt baze i punjenje se mogu pokrenuti u /app/boot/ime.php

Svaki kontroller treba se napraviti kako su vec ovi gotovi, dakle svaki mora imati barem index() funkciju jer je to default koji se poziva kad se napise /controller.

Kako saljemo podatke do ''vidljivih stranica (viewova)'' -> u pripadnoj funkciji controllera idemo : $this->registry->template->ime_varijable = vrijednost;
Zatim ako zelimo ucitati taj trazeni view idemo $this->registry->template->show('ime_viewa_bez_phpa');

Sada je u tom zadanom viewu moguce pristupiti svim varijablama odozgora kao da su vec definirane npr $ime_varijable = vrijednost;


Ako nesto nije jasno, pogledajte authsController.php i auths_ime.php u view, i naravno authservice.class.php (to je implementirana authentifikacija)

Kada bude implmentirana prava ''pocetna stranica'' onda se samo umjesto $this->registry->template->show('auths_uspjeh'); u authsControlleru stavi na to mjesto npr:
header('Location: ' . __SITE_URL . '/index.php?rt=users'); <- da nas prebaci na users controller