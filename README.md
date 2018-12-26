PHP-Allegro-rest-api dla opornych, czyli małe rest-api-howto.

A. Proces rejestracji aplikacji w allegro

1. Logujesz sie do serwisu na swoje konto.
2. na https://apps.developer.allegro.pl/ rejestrujesz swoją aplikację
   a) Możesz podać dowolną nazwę aplikacji np twoj_login-api . Tej nazwy już nie zmienisz
      lecz nie ma to żadnego znaczenia dla aplikacji poza tym, że pojawia się w pytaniu
      do użytkownika, czy zezwala tej aplikacji na dostęp do jego danych.
   b) W polu Adresy przekierowań ja wpisałem nazwę mojego serwera - domenę,
      która na niego wskazuje np. http://twoj_server.com lub https://twoj_server.com
      Później w aplikacji można wskazać konkretny plik.php w którym jest aplikacja.
      Te dane można edytować w Allegro.
   c) Ja miałem już identyfikator SOAP WEB API ( Api KEY ) i pojawił się poniżej. 
      Też jest potrzebny.
   d) Zrób copy + paste do pliku textowego wszystkich kluczy na stronie po zakończeni
      tej rejestracji.

B. Uruchomienie demo na Twoim serwerze.

--
INFORMACJA: całe demo jest oparte o napisany przez Wiatrogon'a php-allegro-rest-api 
dostępne tu: https://github.com/Wiatrogon/php-allegro-rest-api
Ja tylko troszkę poprawiłem procedurę get() i utworzyłem ApiTest.php w oparciu
o fragmenty tamtego pliku README.
Licencja wynika z licencji na php-allegro-rest-api
--

1. Demo używa PHP5. Ja używałem v 5.6. Jeśli coś Ci nie działa, to znaczy,
   że brakuje jakichś modułów w PHP. Proponuję phpinfo() i dodanie modułów
   PHP.
2. Pliki *.php przekopiuj do katalogu /api/demo/ na swoim serwerze. Nie piszę
   o takich drobiazgach, jak odpowiednie prawa (R/W/X) do plików i katalogu oraz
   o tym, że to Twój serwer www powinien widzieć katalog, jako /api/demo/
   Jeśli przeniesiesz demo do innego katalogu - zmień 12 linię pliku ApiTest.php
   Poniżej ( w 13-17 linii tego pliku znajduje się stosowny opis )
3. Plik api_login.php przeedytuj - wpisując tam dane pobrane z allegro ( punkt A.2.d ).
4. Za pomocą przeglądarki wybierz adres: ( https:// lub ) http://your_server.com/api/demo/ApiTest.php
   ( gdzie oczywiście your_server.com to adres Twojego servera ).
   Allegro nie dopuszcza w nazwie serwera adresu IP.

C. Po kilkunastu sekundach powinno pojawić się w przeglądarce dużo textu.
   Jeśli tak nie jest - trzeba jednorazowo uruchomić autentykację ręcznie i będąc 
   zalogowanym do allegro.pl [ zwykłe konto użytkownika ] wyrazić zgodę na dostęp
   aplikacji o nazwie, jaką zarejestrowałeś ( punkt A.2.a ) do Twojego konta.
   W tym celu trzeba odkomentować linię nr 25. Jest tam stosowna instrukcja.
   Po wyrażeniu zgody można tą linię zakomentować spowrotem.

D. W definicji klasy Resource pod koniec zakomentowane są 4 linie tworzące log z zapytań
   wysyłanych do allegro. Mnie to bardzo pomogło w konstrukcji wielu z nich. Jeśli to 
   odkomentujesz - w /tmp/ utworzy się log z tymi zapytaniami.

E. Plik ApiTest.php jest okomentowany przeze mnie w stopniu dość dużym. Zawiera on
   gotowe odpowiedzi na pytanie, jak dotrzeć do listy aukcji i jak wyodrębnić określone
   pola odpowiedzi z serwera Allegro. Na końcu powturzone są też elementy z howto 
   Wiatrogon'a Ja używałem tylko metody GET. Nie mam innych potrzeb na razie. PUT i DELETE
   pozostawiam do przećwiczenia innym.

Have Fun
GrzegorzJJ
