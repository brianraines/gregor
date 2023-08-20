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
sudo apt-get install vim git
```

Turn off Paasword auth in ssh config:
```bash
sudo vim /etc/ssh/sshd_config

PasswordAuthentication no
```

Install firewall:
```bash
sudo apt-get install ufw
sudo ufw allow 22
sudo ufw allow 80
sudo ufw allow 443
sudo ufw show added
```

Install fail2ban:
```bash
sudo apt-get install fail2ban
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

### Install [PCB drivers](https://learn.adafruit.com/adafruit-pitft-3-dot-5-touch-screen-for-raspberry-pi/easy-install-2) for the touchscreen display.
