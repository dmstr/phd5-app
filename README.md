phd
===

### TL;dr

    make all

Start stack

    docker-compose up -d

Create bash    
    
    docker-compose run php bash

Run setup in container    
    
    $ composer install
    $ yii migrate
    $ yii user/create admin@example.com admin secret
    $ yii user/create user@example.com u.ser secret

### Develop

    yii gii/giiant-module --moduleID=crud --moduleClass=app\\modules\\crud\\Module
    
### Release

    docker-compose build
    
#### GitLab    
    
    git push origin master:release