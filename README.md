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
sudo chmod 777 setup
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

### Update HTML dir
```bash
cd assets/html/
```
