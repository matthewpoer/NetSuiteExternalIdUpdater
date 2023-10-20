Vagrant.configure("2") do |config|
  config.vm.box = "damianlewis/ubuntu-16.04-lamp"
  config.vm.provision "shell",
    inline: 'update-alternatives --set php "/usr/bin/php5.6" > /dev/null'
end
