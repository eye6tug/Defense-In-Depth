iptables -L -v

echo "======================================"

# allow incoming and outgoing traffic on the loopback interface

sudo iptables -A INPUT -i lo -j ACCEPT
sudo iptables -A OUTPUT -o lo -j ACCEPT

# allow ESTABLISHED and RELATED incoming traffic on the host

sudo iptables -A INPUT -m conntrack --ctstate ESTABLISHED,RELATED -j ACCEPT
sudo iptables -A OUTPUT -m conntrack --ctstate ESTABLISHED -j ACCEPT
sudo iptables -A INPUT -m conntrack --ctstate INVALID -j DROP

# Protect Against Nmap Scans

sudo iptables -A INPUT -p tcp --tcp-flags ALL NONE -j DROP
sudo iptables -A INPUT -p tcp --tcp-flags SYN,FIN SYN,FIN -j DROP
sudo iptables -A INPUT -p tcp --tcp-flags SYN,RST SYN,RST -j DROP
sudo iptables -A INPUT -p tcp --tcp-flags ALL SYN,RST,ACK,FIN,URG -j DROP
sudo iptables -A INPUT -p tcp --tcp-flags FIN,RST FIN,RST -j DROP
sudo iptables -A INPUT -p tcp --tcp-flags ACK,FIN FIN -j DROP
sudo iptables -A INPUT -p tcp --tcp-flags ACK,PSH PSH -j DROP
sudo iptables -A INPUT -p tcp --tcp-flags ACK,URG URG -j DROP

#  prevent an IP address from creating too many new connections in a short time

sudo iptables -A INPUT -p tcp -i ens33 -m state --state NEW -m recent --set
sudo iptables -A INPUT -p tcp -i ens33 -m state --state NEW -m recent --update --seconds 30 --hitcount 10 -j DROP
sudo iptables -A FORWARD -p tcp -i ens33 -m state --state NEW -m recent --set
sudo iptables -A FORWARD -p tcp -i ens33 -m state --state NEW -m recent --update --seconds 30 --hitcount 10 -j DROP

echo "ADDING RULES"

iptables -L -v

echo "==============================================="
