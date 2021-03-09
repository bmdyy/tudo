#!/bin/sh
docker kill $(docker ps|grep tudo|awk '{split($0,a," "); print a[1]}')