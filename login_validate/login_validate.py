from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.chrome.options import Options
from webdriver_manager.chrome import ChromeDriverManager
import os
import json

chrome_options = webdriver.ChromeOptions()
global driver

with open('C:\wms\config.json') as json_file:
    data = json.load(json_file)

# Seta o driver do chrome com base em uma versão
versionChrome = data['version'] if "version" in data else ''
driver = webdriver.Chrome(ChromeDriverManager(version=versionChrome).install(), chrome_options=chrome_options)

# Seta o link para abrir
link = data['link'] if "link" in data else ''
driver.get(link)

if "user" in data:
    inputUsername = driver.find_element_by_id("cpf")
    inputUsername.clear()
    inputUsername.send_keys(data['user'])

if "pass" in data:
    inputPassword = driver.find_element_by_id("senha")
    inputPassword.clear()
    inputPassword.send_keys(data['pass'])

inputUuid = driver.find_element_by_id("uuid")
uuid = os.popen('wmic csproduct get "UUID"').read().split()[-1]
hostname = os.popen('hostname').read().strip()
inputHostname = driver.find_element_by_id("hostname")

# Seta o UUID como value do input hidden
driver.execute_script('''
    var values = arguments[1]
    arguments[0].forEach(function(item, index) {
        item.value = values[index]
    });
    var oUuid = arguments[0];
    var sValueUuid = arguments[1];
    oUuid.value = value;
    var oHostname = arguments[2];
    var sValueHostname = arguments[3];
    console.log(sValueHostname)
    sValueHostname.value = value;
''', [inputUuid, inputHostname], [uuid, hostname])