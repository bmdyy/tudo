# Solutions
In total there are 6 unique ways to solve this machine. I recommend understanding all 6 to gain the most from TUDO. In this folder you may find my PoC scripts (python3) for every vulnerability.

## Step 1 - Authentication Bypass
#### 1. Dumping password reset token via Blind SQLi
The 'Forgot Username' page is vulnerable to SQLi in the username parameter. We may exploit this to dump password reset tokens, and in turn change the password of an account we chose.

PoC: `dump_token.py`

#### 2. Guessing password reset token via token spray (known random seed)

## Step 2 - Privilege Escalation
#### 1. XSS (Session riding)

## Step 3 - RCE
#### 1. SSTI (MoTD uses Smarty)
#### 2. Image upload bypass (Upload .phar)
#### 3. PHP deserialization (Log writes to file on __destruct)
