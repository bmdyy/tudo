# Info
Name: TUDO

Author: William Moody (@bmdyy)

Date: 08.03.2021

Languages: PHP, PSQL

Created as preparation for the OSWE/AWAE certification exam.

# Goals
1. Gain access to user1/2 account (2 possible routes)

2. Gain access to admin account (1 possible route)

3. Remote Shell (3 possible routes)


Try to find every way, and create a python script which
automates the entire process from an unauthenticated user to a remote shell.


The attack for step 2 may take up to a minute to complete, since the admin's actions
are emulated that often on the virtual machine.

# Credentials
## Web App
* admin:admin
* user1:user1
* user2:user2

## Virtual Machine
tudo:tudo (sudo)

# How to begin?
Two ways:
1. Install VMPlayer, and import the supplied box as an existing virtual machine. Make sure
you can open up the website in the browser, and then you should be ready to tackle the goals.

Virtual machine: 
<google drive link>
  
2. Alternatively, you could run it on your own machine by cloning the git repo in /var/www/html,
and running the following commands:

* sudo apt-get install apache2
* sudo apt-get install libapache2-mod-php7.3
* sudo apt-get install postgresql
* sudo -u postgres psql
	  CREATE DATABASE tudo;
* sudo -u postgres psql -f setup.sql tudo
* sudo apt-get install php7.3-pgsql
* wget https://github.com/mozilla/geckodriver/releases/download/v0.29.0/geckodriver-v0.29.0-linux64.tar.gz
* tar xvf geckodriver-v0.29.0-linux64.tar.gz
* mv geckodriver /usr/bin
* sudo apt-get install python3-pip
* sudo pip3 install selenium
* crontab -e
    */1 * * * * /var/www/html/emulate_admin.py

Good luck :)
