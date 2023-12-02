'use strict';
var Mailgun = require('mailgun-js');
//var method = MailgunLib.prototype;
class MailgunLib {

    constructor() {
        var api_key = env('MailGunAPI');
        //console.log(api_key);
        var domain = env('MailGundomain');

        this.mailgun = new Mailgun({ apiKey: api_key, domain: domain });
        this.listAddress = env('MailGunListAddress');
  
        this.timestamp = (new Date()).getTime();
    }
   
    selectMailTemplate(code,callback) { //console.log(code); //Indicator_update_news
         var query_   = "SELECT `email_templates_message` FROM `email_templates` WHERE `email_templates_code`='"+code+"'";
         return con.query(query_, function(err, rows) {  /*console.log(rows);*/ callback(err, rows) 
         })
    }

    selectEmailAlertMembersForReports(start, end) {
         var results=[];
        var start_end = "LIMIT " + start + "," + end;
        console.log(start_end);
        var query_ = 'SELECT u.fname AS name ,u.email AS address FROM user_accounts AS  u  WHERE u.breaking_News_Alert = "Y" AND u.user_status_id = 4 ORDER BY u.id DESC '+ start_end;
        var rows= Sync_MySqlcon.query(query_);
          if(rows.length)  {
            results=rows;
          }
         return (results);
    }
    getCountofEmailAlertMembers(callback) {
      var results=0;
        var query_ = 'SELECT COUNT(*) as COUNT FROM user_accounts WHERE breaking_News_Alert = "Y" AND user_status_id = 4';
        var rows=Sync_MySqlcon.query(query_);
         if(rows.length)  {
              console.log(rows[0].COUNT);
            results=rows[0].COUNT;
          
            
        }
         return (results);
      

    }
    changeStatus(postId,status,callback) {
        if (status == 'N') { status = 'Y'; } else { status = 'N'; }

        var query_ = "update  `post` set `post_publish_status`  = '"+status+"' where `post_id` = '"+postId+"'";
        return con.query(query_, function(err, rows, fields) { console.log(rows.affectedRows + " record(s) updated"); callback(err,rows.affectedRows)  })
       
    }
    changeMailQuePostStatus(postId,callback) {
        var query_ = 'update  `post_email_queue`  set `post_email_queue_status`  = "Y" where `post_id` = "'+ postId + '"';
       // console.log(query_);
        return con.query(query_, function(err, rows, fields) { console.log(rows.affectedRows + " record(s) updated"); callback(err,rows.affectedRows) })
    }
    fetchPostData(postId,callback) {
      //and post_type = 'N'
         return con.query("select * from `post` where `post_id`='" + postId + "'  and `post_publish_status` != ''", function(err, rows) {   
            if (err)  throw err;
             if(rows.length){ callback(err, rows) }
           /*console.log(rows);callback(err, rows)*/ 

         });
        
       
    }
    updatePostMailNotification(postId) {

        var query_ = "UPDATE `post` SET `post_mail_notification` = 'Y' WHERE `post_id`='" + postId + "' and  `post_mail_notification`= 'N'";
        return con.query(query_, function(err, rows, fields) { console.log(rows.affectedRows + " record(s) updated");  })

    };
    checkAlreadysent(post_type, post_publish_status, post_mail_notification) {
       // console.log(post_type,post_publish_status,post_mail_notification)
        if (post_type == "N" && post_publish_status == "Y" && post_mail_notification == "N") {
            return true;
        }else
        return false;
    };
    getAllParentCategoriesByCategoryId(postCatId){
        var urlstring='';
        var query_ = "CALL getAllParentCategoriesByCategoryId(" + postCatId + ")";
        var rows=Sync_MySqlcon.query(query_);
        
        if(rows.length)  {
            var results=(JSON.parse(JSON.stringify(rows)))[0];
            var urlstring=results.map(function(el){ return el.category_url; }).join('/');
           // console.log(urlstring);   
            
        }
         return (urlstring);   
       
    }
  
    sendPostMailNotification(mailSubject,mailBody,listAddress=false) {
       

        var data = {
            from: 'India Macro Advisors <' + env('MailGunfrom') + '>',
            to:    (listAddress)?listAddress:this.listAddress,
            subject: mailSubject,
            html  :mailBody,
            // attachment: fp,
            'o:tag' : [this.timestamp]
        };
        //console.log(data);

        this.mailgun.messages().send(data, function(error, body) {
            if (error) {  console.log("got an error: ", error); }
            else {
                 //res.send(body);
                console.log(body);
            }
        });


    }
      sendMailGunStatus(mailBody,mailSubject){
      var data = {
            from: 'India Macro Advisors <info@mg.japanmacroadvisors.net>',
            to:    env('JmaDevTeam'),
            subject: mailSubject,
            html  :mailBody,
           
        };
        this.mailgun.messages().send(data, function(error, body) {
            if (error) { console.log("got an error: ", error);  }
          
            else { //res.send(body); console.log(body);
            }
        });  
    }

     sendEventInfo(queryString,postTitle) {
            var self=this;
            //console.log(queryString);
        this.mailgun.get('/'+env('MailGundomain')+'/events', queryString, function(error, body) {
           if (error) { console.log("got an error: ", error);  }else{
            var numOfunSubs = body.items;
            if(numOfunSubs.length >0)
            {

            var UnsubList = [];   
            var UnsubList__='';
            numOfunSubs.forEach(element => { 
                
            UnsubList.push(element.recipient); 
            UnsubList__+=element.recipient+',<br/>';
            }); 
            //console.log(numOfunSubs.length); 
           // console.log(UnsubList); 
           // console.log(UnsubList__);
            //var userList =  UnsubList__.substring(0,-6);
            var mailBody = "<html>Hi Team ,<br/> New post notification mail not sent unsubscribe user mail address lists,<br/><br/>";
            mailBody+=UnsubList__;
            mailBody+="<br/><br/> For more: please see<br/> https://mailgun.com<br/> </html>";
            var mailSubject = "Not send "+postTitle+" post notification - Unsubscribe User Lists";
            // console.log(mailBody);
             self.sendMailGunStatus(mailBody,mailSubject);


            }
        }
        });


      
                                      
        
       
    };

      createNewList(Mail_Obj,usersCount,list_Objects) {
        var postId = Mail_Obj.postId;  var self=this;var member_list_Objects=list_Objects;
        var numberOfUserCount = Math.ceil(usersCount/1000);
        if(env('APP_ENV')=="development" || env('APP_ENV')=="test"){
            var numberOfUserCount = 1;
        }
        
        var datetime = new Date(); var datetime_ = datetime.toISOString().slice(0, 10);
       var mailBody = Mail_Obj.mailBody;var mailSubject = Mail_Obj.mailSubject;
           for(var i=1;i<=numberOfUserCount;i++)
  {
         var loop = i;
      if(i==1)
      {
      var start = 0; var endLimit = 1000;
      }   
      else
      {
      var start = ( i-1)*1000; var endLimit = 1000;                       
      }
    var listName = 'Indicator_' + postId + loop + datetime_; 
    var listAddress = listName + '@mg.indiamacroadvisors.net';
    var params = {
    'address': listAddress,
    'name': listName,
   'description': 'Indicator Mailgun '+env('APP_ENV')+' List - ' + Mail_Obj.indicatorName +'||'+start+'||'+endLimit
    };

      

    this.mailgun.post('/lists', params, function(err, body) {
          
            if (err) {
                // new Error('Mailgun Creating list :'+JSON.parse(JSON.stringify(err)));
                console.log('Mailgun Creating list :'+err);
               // res.send("Error - check console");
            } else {
                
                var listofsendAddress=body.list.address;
                if(env('APP_ENV')=="production"){
                var FindStEn=(body.list.description).split('||'); 
member_list_Objects=self.selectEmailAlertMembersForReports(FindStEn[1],FindStEn[2]);
                 }
                 self.PushmembersToList(listofsendAddress,member_list_Objects);
                 setTimeout(function(){
                self.sendPostMailNotification(mailSubject,mailBody,listofsendAddress);
               }.bind(self), 5000);
                 

                //res.send("Added to mailing list");
            }
        })
  }
        
/*
post("lists/$listAddress/members.json"); 
*/
        

        
    }

   

      PushmembersToList(listAddress,members) {
       
         this.mailgun.lists(listAddress).members().add({ members: members, subscribed: true, upsert: true }, function(err, body) {
           
            if (err) {
                console.log(err);
                //res.send("Error - check console");
            } else {
                //console.log(body);
                //res.send("Added to mailing list");
            }
        });
    };
    

    getListOfInfo() {
        this.mailgun.lists(this.listAddress).info().then(function(data) {
            console.log(data);
        }, function(err) {
            console.log(err);
        });
    }
    getListOfMembers() {
        this.mailgun.lists(this.listAddress).members().list(function(err, members) {
            // `members` is the list of members console.log(members);
        });
    };

    updateMembersInfoToList() {
        this.mailgun.lists(this.listAddress).members('bob@gmail.com').update({ name: 'Foo Bar' }, function(err, body) {
            console.log(body);
        });
    }
    deleteMembersInfoToList() {
        this.mailgun.lists(this.listAddress).members('bob@gmail.com').delete(function(err, data) {
            console.log(data);
        });
    }
    getEmailsFormList() {
        this.mailgun.parse(['test@mail.com', 'test2@mail.com'], function(err, body) {
            if (err) {
                console.log(err);
                // handle error. addresses: body.parsed;
                // do something with unparseable addresses: body.unparseable;
            } else {
                console.log(body);
            }
        });
    };
    Emailvalidate() {
        this.mailgun.validate('veeramani.kamaraj@japanmacroadvisors.com', function(err, body) {
            if (body && body.is_valid) {
                console.log(body);
            }
        }, function(err) {
            console.log(err);
        });
    };

    
}
//Property Push example outside class
/*method.getAge = function() {
return 222;
};*/

/*async function getData() {
  return await axios.get('https://jsonplaceholder.typicode.com/posts');
}

(async () => {
  console.log(await getData())
})()*/

module.exports = MailgunLib;