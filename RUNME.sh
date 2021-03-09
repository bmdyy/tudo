#!/bin/sh
# tries to kill a running tudo container
/bin/bash $PWD/KILL.sh

# starts a new container
docker build -t tudo .
docker run -t tudo