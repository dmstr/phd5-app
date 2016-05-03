solid-ground
============

### TL;dr

    cp .env-dist .env

Start stack

    docker-compose up -d

Create bash    
    
    docker-compose run php bash

Run setup in container    
    
    $ composer install
    $ yii migrate
    $ yii user/create admin@example.com admin secret

### Develop

    yii gii/giiant-module --moduleID=crud --moduleClass=app\\modules\\crud\\Module