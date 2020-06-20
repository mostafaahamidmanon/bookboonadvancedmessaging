BookBoon.com (r) Advanced Messaging using PHP7 and Symfony5
-------------------------------------------------------------

Sample messaging application

Tech stack:

Symfony5

PipelineDB

PostgreSQL11

Kafka

ZooKeeper

The link to the e-book will be published soon on BookBoon.com (r) website



Installation
--------------

``` make ``` To display info

``` make install ``` To install the application

``` make migrate ``` To migrate the DB

``` make seed ``` To seed the DB

Point your browser to ``` https://manondomain.wip:8000/ ```



Consumer
---------

``` make consume ``` To start Symfony Built-In Consumer



Endpoints:
-----------

Check [openapi.yml](openapi.yml)



Destruction
--------------

``` make clean ``` (Stops and removes the containers)



Testing
---------

``` make test ``` (Tests the application)


Accessing containers:
----------------------

PHP ``` make meinphp ```

Kafka ``` make meinkafka ```

PipelineDB ``` make meinpipelinedb ```