
### About

Part of the course DV1608 - Object-Oriented Web Technologies at Blekinge Institute of Technology (BTH). 

The course teaches object-oriented programming for web applications with a focus on the MVC (Model-View-Controller) design pattern. We use the PHP framework Symfony and delve into topics such as database connections with object-relational mapping (ORM), unit testing, and maintaining good code quality.

The web page in this repo features all of these concepts. The final project is Chronos Mansion, an adventure game in which the player is trapped in the "Chronos Mansion" and must find their way out by solving quests.

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/blajban/report/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/blajban/report/?branch=main)

[![Code Coverage](https://scrutinizer-ci.com/g/blajban/report/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/blajban/report/?branch=main)

[![Build Status](https://scrutinizer-ci.com/g/blajban/report/badges/build.png?b=main)](https://scrutinizer-ci.com/g/blajban/report/build-status/main)

### Get going
1. Clone the repo: `git clone git@github.com:blajban/report.git`
2. `composer install`
3. `npm install` 
4. `npm run build`
5. bin/console doctrine:database:create
6. bin/console make:migration
7. bin/console doctrine:migrations:migrate


4. 'npm run start'
5. Go to `localhost:8888`




