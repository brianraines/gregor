# gregor

A digital desktop calendar project.

## Hardware

[Raspberry Pi 3 Model B+](https://www.amazon.com/Raspberry-Pi-Model-Board-Plus/dp/B0BNJPL4MW/)

[Adafruit 3.5" Touchscreen Display](https://www.adafruit.com/product/2441)

[Micro SD Card](amazon.com/gp/product/B0B7NXBM6P/)

## Installation
### Install Raspberry Pi OS using [Raspberry Pi Imager](https://www.raspberrypi.com/software/).

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

Turn off Paasword auth in ssh config:
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


### Setup boot to display
https://pimylifeup.com/raspberry-pi-kiosk/
https://github.com/jwa-7/goodtft-kioskdmesg

```bash
sudo apt purge wolfram-engine scratch nuscratch sonic-pi idle3 -y
sudo apt purge smartsim java-common libreoffice* -y

sudo apt clean
sudo apt autoremove -y

sudo apt-get update -y && sudo apt-get full-upgrade -y

sudo apt install xdotool unclutter sed -y

sudo apt install xserver-xorg-input-evdev
sudo cp -rf /usr/share/X11/xorg.conf.d/{10,45}-evdev.confdmesg | grep graphics

sudo raspi-config
1 System Options -> S5 Boot / Auto Login -> B4 Desktop Autologin
```

Add the kiosk.sh script to the home directory:
```bash
vim kiosk.sh
```

```bash


```

Set the permissions on the script:
```bash
chmod u+x ~/kiosk.sh
```

Create a kiosk.service file:
```bash
sudo vim /lib/systemd/system/kiosk.service
```

```bash
[Unit]
Description=Chromium Kiosk
Wants=graphical.target
After=graphical.target

[Service]
Environment=DISPLAY=:0.0
Environment=XAUTHORITY=/home/brian/.Xauthority
Type=simple
ExecStart=/bin/bash /home/brian/kiosk.sh
Restart=on-abort
User=brian
Group=brian

[Install]
WantedBy=graphical.target
```

Add and start the service
```bash
sudo systemctl enable kiosk.service
sudo systemctl start kiosk.service
```