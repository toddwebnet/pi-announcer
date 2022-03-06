#Raspberry Pi Text To Speech
A collection of scripts and api that will 
create a platform to play text to speech on a raspberry pi
from internal or remote code execution
---

Tested on Raspberry Pi 4 with 64 bit Rasberry pi os (with desktop)

```bash 
sudo apt install -y php espeak
```

run composer
```
cd ~/pi-announcer/src/web
composer install
```

setup web app
```
cd ~/pi-announcer/src/web
cp .env.example .env
php artisan key:generate
nano .env
#  add this line to env (with correct path)
ANNOUNCER_DROP_PATH=/home/pi/pi-announcer/drops/
```


edit the following files to update config vars
```
src/cron/cron_speaker
  - define('DROP_FOLDER', '/home/pi/pi-announcer/drops');
  
src/cron/run_web_server
  - $path    = "/home/pi/pi-announcer/src/web";
  - $user    = 'pi';
  - $ip      = "{IP address of server}";

```

setup crontab
sudo crontab -e
```
* * * * * php /home/pi/pi-announcer/src/cron/cron_speaker.php >/dev/null
```
as pi
crontab -e
```
* * * * * php /home/pi/pi-announcer/src/cron/run_web_server.php >/dev/null
```

