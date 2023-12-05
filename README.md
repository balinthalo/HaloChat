## Chat applikáció
- Regisztrációs és bejelentkezési felülettel rendelkezik 
- Nem kell újratölteni az oldalt az új üzenetek megtekintéséhez
- Üzenetküldéskor automatikusan újratöltés nélkül renderelődnek az új saját üzenetek is
- Képes a felhasználó létrehozni, szerkeszteni és törölni chat szobákat, melyeket egyedi névvel láthat el
    - Létrehozáskor legalább 1 tag megadása kötelező
        - Amennyiben önmagát választja, úgy a chat-et kizárólag ő láthatja
        - Amennyiben mást jelöl meg, úgy a chat-ez a megjelölt személy és saját maga is hozzá lesz társítva
- Képes a felhasználó új emberek meghívására a beszélgetéshez
- Az üzenetküldés egy háttérben lefutó POST kérés a szerver fele, így az oldalon nem vehető észre a DOM frissülés üzenet küldését követően
- A chat első betöltésekor és minden saját üzenet elküldése után automatikusan az utolsó üzenethez ugrik
- A chatben nem lehet HTML tag-eket megadni így nem lehet JavaScript kódot injektálni (ezt a szerver oldalon utólag szűri ki az üzenetből)
- a chatjeim és bármely chat betöltéséhez be kell jelentkezni illetve ellenőrzi hogy van-e hozzá jogosultság (jelen eseben csak az hogy tagja-e a beszélgetésnek vagy sem)
    - A háttérben (API) lekért vagy elküldött kérések esetében is lefut az ellenőrzés
- Minden elküldött form esetében egy backend validáció ellenőrzi, hogy mindig megfelelő adatokat kapjunk és rögzítsünk
    - Például nem adható át DOM mannipulációval egy nem létező felhasználó azonosítója (ID) a chat-hez való meghíváskor

## Felhasznált technológiák
Backend:
- PHP 8.2,
- Laravel 10.x
Frontend:
- Vite 4.x
- TailwindCSS 3.x
- JavaScript, HTML
- Axios

## Javaslatok további fejlesztésekhez 
- Felhasználói felület (szerkeszthető profilkép, felhasználói adatok, jelszavak stb.)
- Jelszó szűrése regex-el hogy megfelelően erős legyen biztonság szempontjából (hosszúság, kisbetű, nagybetű, szám, speciális karakter megléte szükséges lehet)
- GDPR szerinti adatvédelmi tájékoztatás mely regisztrációhoz szükséges elfogadni (ezt a tárolt email cím különösen indokolja)
- Vue.js használata frontend készítéshez
- Barátlista készítése (idegenek számára a profilok láthatatlanok lennének, és kizárólag csak a barátlistásokkal lehetne közös chat-csoportokat alkotni)
- Meghívó küldése még nem regisztrált felhasználók számára
- Websocketek használata
