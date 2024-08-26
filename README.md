# jv_typoscript
Request Typoscript settings as ajax. Usefull in a command Controller

# Installation
--------------

Admin tools -> settings -> Extension Configuration 


## allowed:
--------------
Add List of allowed Extensions, comma separated, 
to allow to get TYPOSCRIPT Values from that extensions.   

if you add news to existing "tx_jvtyposcript,news" you will get all settings for both extensions with

    https://<your Domain>/<pathToPage>/?tx_jvtyposcript=all

or only for one Plugin with: 

    https://<your Domain>/<pathToPage>/?tx_jvtyposcript=tx_jvtyposcript
    https://<your Domain>/<pathToPage>/?tx_jvtyposcript=tx_news_list

Will NOT work:
get all settings of a complete Extension. (Only for a plugin as above)

    https://<your Domain>/<pathToPage>/?tx_jvtyposcript=tx_news

# Todo:
### disallowedKeys
--------------

implement to remove disallowed keys from configuration



## Internal reminder for the extension maintainer:
To Update this extension in TER: \
change version Number to "x.y.z" in Documentation\ in Settings.cfg and Index.rst \
create Tag "x.y.z" \
git push --tags

create new zip file: \
cd vendor/jvelletti/jve-template \
git archive -o "jve_typoscript_x.y.z.zip" HEAD

f.e.: \
git archive -o "jve_template_12.4.11.zip" HEAD


Upload ZIP File to https://extensions.typo3.org/my-extensions \
git push

setup packagist Webhook: \
https://packagist.org/api/update-package?username=jvelletti

api Token from Profile: \
https://packagist.org/profile/

check: \
https://intercept.typo3.com/admin/docs/deployments \
https://packagist.org/packages/jvelletti/jv-template \
https://extensions.typo3.org/extension/jv_template/ 
