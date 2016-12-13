#!/bin/bash
yum -y update
yum install -y docker
service docker start
curl -L "https://github.com/docker/compose/releases/download/1.9.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose/
wget http://guyl.me/exquisitecorpse/docker-compose.yml
docker-compose up -d
