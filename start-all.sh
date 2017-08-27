#!/bin/sh

cd "$( dirname "$0" )" 

node server/app2 &
node server_lobby/app &
php server2/server.php
