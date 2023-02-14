![TUDO Favicon](https://github.com/bmdyy/tudo/blob/main/favicon.ico?raw=true)

# TUDO (Vulnerable PHP Web-App)

## MetaData
* Author: William Moody (@bmdyy)
* Started: 08.03.2021
* Languages: PHP, PostgreSQL
* Created as preparation for the OSWE/AWAE certification exam.

## Goals
This is an intentionally vulnerable web application. There are 3 steps to complete the challenge, and multiple ways
to complete each step.

1. You must gain access to either user1, or user2's account (2 possible ways)
2. Next, gain access to the admin account (1 possible ways)
3. Finally, find a way to remotely execute arbitrary commands (5 possible ways)

I would suggest to try and find every way to get the most out of TUDO.
Bonus: Create a python script which chains together all 3 steps for a complete POC.

*Note: The attack for step 2 may take up to a minute to complete, since the admin's actions
are emulated with a cron job every minute on the target machine.*

This is intended as a **white-box** penetration test, so open up VSCode, and read.

## Default Credentials
* admin:admin
* user1:user1
* user2:user2

## How to begin?
1. Clone the repo: `git clone https://github.com/bmdyy/tudo.git`
2. Go into the directory: `cd tudo`
3. Execute: `./RUNME.sh`
4. Look in the terminal output and you should see an IP address: `AH00558: apache2: ... 172.17.0.2 ...'`
That is the target!

*Note: If you want to shutdown the container, you may use `KILL.sh` for convenience.*

*Note 2: I included `SHELL.sh` as a quick way to run a shell for the docker container*

## Solutions
There are explanations and solutions for all (intended) ways to solve this machine in `/solution`.

**And finally, good luck!**
