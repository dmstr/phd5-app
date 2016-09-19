phd5
====

A universal web application template built upon Docker, PHP and Yii 2.0 Framework

Documentation
-------------
 
See [docs](https://git.hrzg.de/dmstr/docs-phd5)

TL;dr
-----

### Requirements

- docker

### Development

    make all

Show help

    make help

Create bash    
    
    make bash

Run setup in container    
    
    $ yii app/setup

See [configuration](https://git.hrzg.de/dmstr/phd-docs/blob/master/developer/configuration.md)...


### Testing

Run command from `tests` folder

    cd tests

Setup test application stack    
    
    make up setup bash
    
Run tests inside the container    
      
    $ codecept run      

See [testing](https://git.hrzg.de/dmstr/phd-docs/blob/master/developer/testing.md)...   


---

#### ![dmstr logo](http://t.phundament.com/dmstr-16-cropped.png) Built by [dmstr](http://diemeisterei.de)        
