Detta repo har skapats inom ramen för kursen [MVC](https://dbwebb.se/kurser/mvc-v2/) på BTH. Repot innehåller krav som genomförts kopplat till de kursmoment kursen består av.

Kursen har berört PHP-ramverket Symfony, objektorienterad programmering, testning, databas samt analys av kod. Under kursens gång har bland annat mindre applikationer skrivits.

Följande är de badges kopplade till delar av de analyser av kodkvalitet som gjorts:

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nsbcj/mvc_report/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/nsbcj/mvc_report/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/nsbcj/mvc_report/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/nsbcj/mvc_report/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/nsbcj/mvc_report/badges/build.png?b=main)](https://scrutinizer-ci.com/g/nsbcj/mvc_report/build-status/main)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/nsbcj/mvc_report/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)

För att klona report använd följande kommando:
```
git clone https://github.com/nsbcj/mvc_report.git
```

Efter att ha klonat repot, starta webbplatsen genom att använda följande kommando i repot rot-folder:
```
composer install
npm run build
php -S localhost:<port> -t public
```
