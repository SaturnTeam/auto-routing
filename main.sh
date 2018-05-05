if [[  ! -d "z-i" ]]
then
    echo "First run"
    echo "Clone repository"
    git clone https://github.com/zapret-info/z-i --depth 1 
fi
echo "Change directory"
cd z-i
echo "Pull changes"
git pull
cd ..
rm ip-ranges.json
wget https://ip-ranges.amazonaws.com/ip-ranges.json
echo "Write  blocked ips to file"
grep -o '[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}' ip-ranges.json z-i/dump.csv | grep -o '[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}\.'  |  sort -u > ips.txt

php main.php
systemctl restart openvpn@server
