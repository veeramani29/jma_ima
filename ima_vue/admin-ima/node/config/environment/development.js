'use strict';
function envConf(){

var details = {
'appication_path': '',
'environment': '',
//SMTP mail configurations
'SMTPserver': env_var.MAIL_HOST,
'SMTPport': env_var.MAIL_PORT,
'SMTPusername': env_var.MAIL_USERNAME,
'SMTPpassword': env_var.MAIL_PASSWORD,
};
return details;


}
 
module.exports= {
  envConf: envConf
 
};