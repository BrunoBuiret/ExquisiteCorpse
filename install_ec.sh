# Execute theses lignes on the server
sudo yum -y update
sudo yum install -y docker
sudo service docker start
sudo curl -L "https://github.com/docker/compose/releases/download/1.9.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose/
wget http://guyl.me/exquisitecorpse/docker-compose.yml
sudo mkdir /opt/acme/
sudo touch /opt/acme/acme.json
sudo docker-compose up -d
