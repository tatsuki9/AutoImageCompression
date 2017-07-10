#!bin/sh

curl -L https://github.com/docker/compose/releases/download/1.2.0/docker-compose-`uname -s`-`uname -m` > /usr/local/bin/docker-compose

chmod +x /usr/local/bin/docker-compose

echo "DOCKER_OPTS=\"$DOCKER_OPTS --insecure-registry=aws-common-registory.aws.nubee.com:5000\"" >> /etc/default/docker

service docker stop
service docker start