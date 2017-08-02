#!/bin/sh

cd "$( dirname "$0" )" 

sudo node server/app2 &
sudo node server_lobby/app &
php server2/server.php