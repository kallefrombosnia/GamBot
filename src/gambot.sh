#!/bin/bash
if [ $1 = 'stop' ]
then
screen -X -S gambot exit
echo "Script sucessfully stopped! To start it type ./gambot.sh start"
fi

if [ $1 = 'start' ]
then
screen -A -m -d -S gambot php rulet.php
echo "Script sucessfully started! To stop it type ./gambot.sh stop"
fi