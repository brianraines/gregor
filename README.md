# gregor

A digital desktop calendar project.

## Hardware

[Raspberry Pi 3 Model B+](https://www.amazon.com/Raspberry-Pi-Model-Board-Plus/dp/B0BNJPL4MW/)

[Adafruit 3.5" Touchscreen Display](https://www.adafruit.com/product/2441)

[Micro SD Card](amazon.com/gp/product/B0B7NXBM6P/)

## Installation
### Install Raspberry Pi OS using [Raspberry Pi Imager](https://www.raspberrypi.com/software/).

Use the latest version of [Raspberry Pi OS Lite](https://downloads.raspberrypi.org/raspios_lite_armhf/images/raspios_lite_armhf-2023-05-03/#:~:text=%2D-,2023%2D05%2D03%2Draspios%2Dbullseye%2Darmhf%2Dlite.img.xz,-2023%2D05%2D03).

Be sure to enable SSH, WiFi, and a default user in the advanced options. I also set the hostname to `gregor`.

Setup ssh keys for the Raspberry Pi:

```bash
ssh-copy-id -i ~/.ssh/id_rsa_your.pub brian@gregor.local
```

SSH into the Raspberry Pi and run the following commands:

Update the system:
```bash
sudo apt-get update -y && sudo apt-get full-upgrade -y
```

Install some packages:
```bash
sudo apt-get install vim git -y
```

Turn off Password auth in ssh config:
```bash
sudo vim /etc/ssh/sshd_config

PasswordAuthentication no
```

Install firewall:
```bash
sudo apt-get install ufw -y
sudo ufw allow 22
sudo ufw allow 80
sudo ufw allow 443
sudo ufw show added
sudo ufw enable
```

Install fail2ban:
```bash
sudo apt-get install fail2ban -y
sudo cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local
sudo vim /etc/fail2ban/jail.local

[sshd]
enabled = true
filter = sshd
port = ssh
banaction = iptables-multiport
bantime = -1
maxretry = 3
logpath = %(sshd_log)s
backend = %(sshd_backend)s

[apache-badbots]
enabled = true
filter = apache-badbots

sudo service fail2ban restart
```

### Clone this repo
```bash
git clone https://github.com/brianraines/gregor.git
```

### Run Setup
```bash
cd gregor
chmod 777 -Rf scripts/
cd scripts
sudo ./setup --debug
```

### Add X File
```bash
sudo vim /usr/share/X11/xorg.conf.d/99-fbdev.conf

Section "Device"
  Identifier "touchscreen"
  Driver "fbdev"
  Option "fbdev" "/dev/fb0"
EndSection
```

### Reboot
```bash
sudo reboot
```

## Modifying the Gregor Calendar
### Update HTML dir
```bash
cd ~/gregor/assets/html/
```

Local Development (requires [Docker](https://docs.docker.com/get-docker/)):
```bash
docker-compose up -d
```

Then visit http://localhost:8080

To stop the container:
```bash
docker-compose down
```

OpenWeatherMap API Key:
```bash
https://openweathermap.org/
```

You will need to set the following environment variables:
```bash
sudo vim /etc/environment
```
adding the following:
```bash
WEATHER_API_KEY=yourapikey
```

You can verify that the environment variables are set by running:
```bash
printenv | grep WEATHER_API_KEY
```

### Color Palatte
Using [Colour Lovers](https://www.colourlovers.com/palette/2563512/dont_trust_me)
or [Coolors](https://coolors.co/040d38-193d61-4ebca1-b9d7bd-efe8cb)

| Hex     | Color                                |
|---------|--------------------------------------|
| #040D38 | $${\textcolor{040D38}{Penn Blue}}$$  |
| #193D61 | $${\textcolor{193D61}{Indigo dye}}$$ |
| #4EBCA1 | $${\textcolor{4EBCA1}{Keppel}}$$     |
| #B9D7BD | $${\textcolor{B9D7BD}{Celadon}}$$    |
| #EFE8CB | $${\textcolor{EFE8CB}{Parchment}}$$  |

### Design
You will find a PSD file at `~/gregor/assets/psd/gregor.psd` that you can use to redesign the calendar.

### 3D Printing the Case
You will find a pair of STL files at `~/gregor/assets/stl/` that you can use to 3D print the `top.stl` and `base.stl` of the case.

#### Thingiverse Model:
[Raspberry Pi 3(2) OctoPi Case with Touch Screen (OctoTouch)](https://www.thingiverse.com/thing:3103425) design by [ironMANN](https://www.thingiverse.com/ironmann)

## Command Line Interface

To put the display to sleep:
```bash
~/gregor/scripts/sleep
```

To wake the display up:
```bash
~/gregor/scripts/wake
```

To refresh chormium (get a fresh weather forecast):
```bash
~/gregor/scripts/refresh
```

To trigger these with cron, add the following to your crontab:
```bash
0 8 * * *  /home/yourusername/gregor/scripts/wake
0 17 * * * /home/yourusername/gregor/scripts/sleep
0 * * * * /home/yourusername/gregor/scripts/refresh
```