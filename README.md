SETUP WITHOUT VAGRANT 
-----------------------------------------------------------------------------------

Composer, PHP and Mailhog hvae been added to the ./bin directory that way this project
can be run from your local machine without the need of Vagrant. 

1. $ git clone git@github.com:joscraw/lorman.git
2. $ cd $PROJECT_ROOT  
3. $ ./bin/composer install
4. $ vendor/bin/phinx migrate -e development
5. $ ./bin/php -S 0.0.0.0:8888 -t public


Go ahead and visit http://localhost:8888/ in your browser!

RUN TEST SUITE
---------------
(Make sure the PHP server is running before you run the test suite)

./vendor/bin/phpunit

TEST EMAIL SENDING 
------------------

(Make sure the PHP server is running as well before you start the mailhog server)

1. $ cd $PROJECT_ROOT  
2. ./bin/mailhog

Go ahead and visit http://127.0.0.1:8025/ in your browser!



SETUP WITH VAGRANT
-----------------------------------------------------------------------------------
1. Head over to Vagrant and download and install the latest version for your system
https://www.vagrantup.com/downloads.html
2. Head over to virtual box and download and install the latest version for your sytem
https://www.virtualbox.org/wiki/Downloads
3. $ git clone git@github.com:joscraw/lorman.git
4. $ cd $PROJECT_ROOT 
5. $ cp ./phpunit.xml.dist ./phpunit.xml
6. Open up ./phpunit.xml and Change <server name="BASE_URL" value="http://0.0.0.0:8888/"/> to <server name="BASE_URL" value="http://192.168.56.108:9999/"/> on line 9
7. $ vagrant up (This can take 5-10 minutes for your VM to be setup. Once this is done you can continue onto the next steps)
8. $ vagrant ssh
9. $ echo "export VAGRANT=true" >> ~/.bash_profile && source ~/.bash_profile 
10. $ cd /var/www
11. $ composer install
12. $ vendor/bin/phinx migrate -e development_vagrant
13. $ php -S 0.0.0.0:9999 -t public

Go ahead and visit http://192.168.56.108:9999/ in your browser!

RUN TEST SUITE
---------------

(Make sure the PHP server is running before you run the test suite)

1. $ cd $PROJECT_ROOT
2. ./vendor/bin/phpunit

TEST EMAIL SENDING USING MAILHOG
--------------------------------

The vagrant machine included in this project has mailhog installed. Once your VM is up and 
running just point your browser to the below URL and you can see each email 
submission and the email content after the contact form has been filled out

http://192.168.56.108:8025/
