# jv_typoscript
Request Typoscript settings as ajax. Usefull in a command Controller

# Installation
--------------

Add List of Extensions, comma separated, 
to allow to get TYPOSCRIPT Values from taht extensions.  




## Internal reminder for the extension maintainer:
To Update this extension in TER: \
change version Number to "x.y.z" in Documentation\ in Settings.cfg and Index.rst \
create Tag "x.y.z" \
git push --tags

create new zip file: \
cd vendor/jvelletti/jve-upgradewizard \
git archive -o "jve_upgradewizard_x.y.z.zip" HEAD

f.e.: \
git archive -o "jve_upgradewizard_12.4.11.zip" HEAD


Upload ZIP File to https://extensions.typo3.org/my-extensions \
git push

setup packagist Webhook: \
https://packagist.org/api/update-package?username=jvelletti

api Token from Profile: \
https://packagist.org/profile/

check: \
https://intercept.typo3.com/admin/docs/deployments \
https://packagist.org/packages/jvelletti/jve_upgradewizard \
https://extensions.typo3.org/extension/jve_upgradewizard/ 
