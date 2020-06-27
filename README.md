BookBoon.com (r) Advanced Messaging using PHP 7 and Symfony 5
-------------------------------------------------------------

Sample messaging application


Tech stack:
-----------

Symfony 5

Pipeline DB

PostgreSQL 11

Kafka

Kafka Manager

ZooKeeper

PHP Unit

Enqueue Kafka

Messenger Component


The link to the e-book will be published soon on BookBoon.com (r) website



Installation
--------------

``` make ``` To display make commands info

``` make install ``` To install the application

``` make migrate ``` To migrate the DB

``` make seed ``` To seed the DB

``` make restart ``` To restart the application inside the container and clears the cache

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

PipelineDB ``` make meinpipeline ```


Release Management:
--------------------

``` make release ``` (Make sure that https://github.com/liip/RMT is installed properly in your system)