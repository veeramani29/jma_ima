#!/usr/bin/php
<?php
fwrite(STDOUT, "Enter Auth file path ?")
$auth_file = trim(fgets(STDIN));

fwrite(STDOUT, "Enter Webserver IP?")
$server_ip = trim(fgets(STDIN));
/*
$passphrase = "jma";
$key_private = openssl_get_privatekey(file_get_contents($auth_file), $passphrase);
$key_public = openssl_get_publickey(file_get_contents($auth_file));

$connection = ssh2_connect($server_ip, 22, array('hostkey'=>'ssh-rsa'));

if (ssh2_auth_pubkey_file($connection, 'username',
                          '/home/username/.ssh/id_rsa.pub',
                          '/home/username/.ssh/id_rsa', 'secret')) {
  echo "Public Key Authentication Successful\n";
} else {
  die('Public Key Authentication Failed');
}
*/
system('sudo rsync --exclude=.svn -r /home/workspace/example.com/backup "ssh -i '.$auth_file.'" ec2-user@12.34.55.66:/var/www/example.com/');

/*
f you want to set up an automated script to copy a file between two systems, you can do so with the SCP or SFTP functions mentioned earlier. Usually, copying a file between systems requires no feedback or response, so your scripts will be very small and simple to write:

#!/usr/bin/php
<?php
$connection = ssh2_connect('shell.example.com', 22);

ssh2_auth_password($connection, 'username', 'password');

ssh2_scp_send($connection, '/home/khess/blah.txt', '/home/khess/blah.txt', 0644);
?>

*/

?>