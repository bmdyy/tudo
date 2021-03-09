![TUDO Favicon](https://github.com/bmdyy/tudo/blob/favicon.ico?raw=true)

# Info
* Name: TUDO
* Author: William Moody (@bmdyy)
* Date: 08.03.2021
* Languages: PHP, PSQL
* Created as preparation for the OSWE/AWAE certification exam.

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
* tudo:tudo (sudo)

# How to begin?
1. Clone the repo
	`git clone https://....`
2. Go into the directory
3. Run `RUNME.sh`

If you want to shutdown the container, you may use `KILL.sh` for convenience.
