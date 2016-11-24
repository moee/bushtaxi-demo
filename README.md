# bushtaxi-demo
This repository demonstrates how [bushtaxi](https://github.com/moee/bushtaxi) can be used to create microservices in PHP that communicate with ZeroMQ.

## Installation

`docker-compose -f docker-compose-install.yml up`

## Run it

`docker-compose up`

## What does it do?

If you run `docker-compose up`, 5 services will be started:

* topics api 
* votes api
* topics bushtaxi
* votes bushtaxi
* proxy

The communication flows like this

!(Bushtaxi Demo Communcation Flow)[images/bushtaxi_demo_communication.png]


