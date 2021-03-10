# Solutions
In total there are 6 unique ways to solve this machine. I recommend understanding all 6 to gain the most from TUDO. In this folder you may find my PoC scripts (python3) for every vulnerability *(work in progress)*.

## Step 1 - Authentication Bypass
#### 1. Dumping password reset token via Blind SQLi
The 'Forgot Username' page is vulnerable to SQLi in the username parameter. We may exploit this to dump password reset tokens, and in turn change the password of an account we chose.

PoC: `dump_token.py`

#### 2. Guessing password reset token via token spray (known random seed)
The function used when creating password reset tokens, 'generateToken()', uses a predictable seed for rand. Because of this, we can generate a list of possible tokens and try them all until we got the right one.

PoC: `token_spray.py`, `token_list.php`

## Step 2 - Privilege Escalation
#### 1. XSS (Session riding)
The 'Description' field of every user (modifiable in 'Profile') is not filtered properly and can execute HTML code when displayed on the admin's home page. We can exploit this to steal the admin's session cookie when he logs in (every minute thanks to a cron job)

PoC: `steal_cookie.py`

## Step 3 - RCE
#### 1. Server Side Template Injection
The admin may set a message of the day which is shown to every user on the home screen. This MoTD is rendered as a template using [Smarty](https://www.smarty.net/), which is vulnerable to SSTI.

PoC: `set_motd.py`

#### 2. Image Upload Bypass (Upload .phar)
The admin may upload images to display below the MoTD. The filter in place may be bypassed to allow us to upload code which executes server side, such as a .phar file.

PoC: `image_upload.py`

#### 3. PHP Deserialization
The admin may import users to the system from serialized PHP objects. We can pass any serialized object in fact, and the class 'Log' writes to an arbitrary file in the '\_\_destruct()' function, so we can use this to write executable code to the web root and then run it.

PoC: `deserialize.php`, `serialize.php`

## Full Chain
A shell script which can demonstrate all 6 vulnerability chains is included (`chain.sh`).
