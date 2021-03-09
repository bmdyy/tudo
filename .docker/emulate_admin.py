#!/usr/bin/python3

# ------SPOILERS------
# Emulates admin actions necessary for privilege escalation 
# from a basic user account to admin.

from selenium import webdriver
from selenium.webdriver.common.keys import Keys
import time

opts = webdriver.FirefoxOptions()
opts.add_argument("--headless")
driver = webdriver.Firefox(firefox_options=opts)
driver.get("http://localhost/login.php")
assert "TUDO/Log In" in driver.title

u_input = driver.find_element_by_name("username")
p_input = driver.find_element_by_name("password")
u_input.send_keys("admin")
p_input.send_keys("admin")
p_input.send_keys(Keys.RETURN)

time.sleep(5)
driver.close()
