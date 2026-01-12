# Karting Rezervacioni Sistem

Laravel aplikacija za rezervaciju karting vožnji.

## Funkcionalnosti
- Registracija i login korisnika
- Rezervacija vožnje (datum, vreme, paket, broj ljudi)
- Pregled sopstvenih rezervacija
- Otkazivanje rezervacija
- Admin panel za upravljanje svim rezervacijama

## Kako pokrenuti aplikaciju
1. Skinuti kod sa: https://github.com/vukj03/Laravel-karting
2. Instalirati PHP pakete sa: `composer install`
3. Podesiti bazu podataka `kartingg` u .env fajlu
4. Pokrenuti migracije: `php artisan migrate --seed`
5. Pokrenuti server: `php artisan serve`
6. Otvoriti http://localhost:8000 u browseru

## Admin pristup
Email: admin@test.com
Lozinka: password

## Tehnologije
- Laravel 10
- MySQL baza podataka
- Bootstrap 5 za dizajn
- Laravel Breeze za login/registraciju

## GitHub Actions
Aplikacija ima podešen GitHub Actions za automatsko testiranje.

## Linkovi
- GitHub repozitorijum: https://github.com/vukj03/Laravel-karting
- Figma dizajn: https://www.figma.com/make/moYVrCj9PH6tXmJ77rQnoW/Karting-Center-App?t=vnid9xCTg54ZyJCH-20&fullscreen=1
- Sifra za admin: admin123