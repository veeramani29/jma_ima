const { check,validationResult }= require('express-validator');
 const MailgunLib = require(path.join(__dirname, '../lib/MailgunLib'));

//Get Null value
router.get('/getNull',(req, res,err)=>{
	res.send(" ");
});

//Get post data
router.get('/getPost',(req, res,err)=>{
	con.query('SELECT * FROM '+post_table+' p JOIN '+postCategory_table+' pc ON p.post_category_id=pc.post_category_id JOIN '+copyWriter_table+' c ON p.copywriter_id=c.copywriter_id', (err, rows, fields) => {
		if (!err)
			res.send(rows);
		else {
			console.log(err);
			res.send({err_code:"manual",message:getError});
		}
	}) 
});

//Get edit post data
router.post('/getEditPostData',(req, res,err)=>{
	con.query('SELECT * FROM '+post_table+' p JOIN '+postCategory_table+' pc ON p.post_category_id=pc.post_category_id JOIN '+copyWriter_table+' c ON p.copywriter_id=c.copywriter_id WHERE post_id ='+req.body.post_id, (err, rows, fields) => {
		if (!err)
		res.send(rows);
		else {
			console.log(err);
			res.send({err_code:"manual",message:getError});
		}
	})
});

//Save Files in the server
router.post('/saveFile',upload.single('UploadFiles'),(req, res,err)=>{
	res.send(req.file.path);	 
});

//Insert post data
router.post('/addPost',[check('post_category_id').isNumeric(),check('post_title').isLength({min:2}),check('post_cms_small').isLength({min:5}),check('post_cms').isLength({min:10})],(req, res,err)=>{
	const errors = validationResult(req)
	if (!errors.isEmpty()) {
		return res.send({err_code:"manual",message:validationError});
	}
	con.query('INSERT INTO '+post_table+' SET ?',req.body, (err, rows, fields) => {
		if (!err){
				console.log("Inserted successfully");
				res.send("Inserted successfully");
		}else{
			console.log(err);
			res.send({err_code:"manual",message:insertError});
		}
	})	
});

//Update post data
router.post('/updatePost',[check('post_category_id').isNumeric(),check('post_title').isLength({min:2}),check('post_cms_small').isLength({min:5}),check('post_cms').isLength({min:10})],(req, res,err)=>{
	const errors = validationResult(req)
	if (!errors.isEmpty()) {
		return res.send({err_code:"manual",message:validationError});
	}
	con.query('Update '+post_table+' SET ? WHERE post_id = '+req.body.post_id,req.body, (err, rows, fields) => {
		if (!err){
			console.log("Updated successfully");
			res.send("Updated successfully");
		}else{
			console.log(err);
			res.send({err_code:"manual",message:updateError});
		}
	})	
});


//Update post Status
router.post('/updatePostStatus',(req, res,err)=>{
	con.query('Update '+post_table+' SET ? WHERE post_id = '+req.body.post_id,req.body, (err, rows, fields) => {
		if (!err){
			console.log("Post Status Updated successfully");
			res.send("Post Status Updated successfully");
		}else{
			console.log(err);
			res.send({err_code:"manual",message:updateError});
		}
	})	
});

//Insert Update archive data
router.post('/archivePost',(req, res,err)=>{
	const currentDate = new Date();
    const dateTime = currentDate.getFullYear() + "-" + (currentDate.getMonth() + 1) + "-" + currentDate.getDate() + " " +  currentDate.getHours() + ":" + currentDate.getMinutes() + ":" + currentDate.getSeconds();
	// console.log(dateTime);
	// con.query("SELECT id,post_cms FROM "+archive_table+" WHERE  post_title= '"+req.body.post_title+"' ORDER BY id DESC LIMIT 1", (err, post_cms, fields) => {
	// 	post_cms(rows);
	// });
	// console.log(postCms);
	con.query("SELECT id,SUBSTRING_INDEX(post_datetime,' ',1) AS column_date FROM "+archive_table+" WHERE  post_title='"+req.body.post_title+"' HAVING DATEDIFF('"+dateTime+"',column_date) < '15'", (err, rows, fields) => {
		console.log(rows.length);
		con.query("SELECT id,post_cms FROM "+archive_table+" WHERE  post_title= '"+req.body.post_title+"' ORDER BY id DESC LIMIT 1", (err, post_cms, fields) => {
			if(post_cms[0].post_cms.replace(/<\/?[^>]+(>|$)/g, "") != req.body.post_cms.replace(/<\/?[^>]+(>|$)/g, "")){
				if(rows.length != 0){
					con.query('Update '+archive_table+' SET ? WHERE id = '+rows[0].id,req.body, (err, rows, fields) => {
						if (!err){
							console.log("Archive updated successfully");
							res.send("Archive updated successfully");
						}else{
							console.log(err);
							res.send({err_code:"manual",message:updateError});
						}
					})	
				} else {
					con.query('INSERT INTO '+archive_table+' SET ?',req.body, (err, rows, fields) => {
						if (!err){
							console.log("Archive inserted successfully");
							res.send("Archive inserted successfully");
						}else{
							console.log(err);
							res.send({err_code:"manual",message:insertError});
						}
					})	
				}
			} else {
				console.log("Archive contents are same");
				res.send("Archive contents are same");
			}
		});
		//  res.send(rows);
	})
	// console.log(test);
	
});


//Delete post data
router.post('/deletePost',(req, res,err)=>{
	con.query('DELETE from '+post_table+' WHERE post_id = '+req.body.id, (err, rows, fields) => {
		if (!err){
			console.log("Deleted successfully");
			res.send("Deleted successfully");
		}else{
			console.log(err);
			res.send({err_code:"manual",message:deleteError});
		}
	})	
});

//Delete file from the server
router.post('/deleteFile',(req, res,err)=>{
	console.log(req.body.path);
	if(fs.unlinkSync(req.body.path));
	console.log("file removed");
	res.send(req.file.path);	
});

//Sent email alert
router.get('/send-email-alert/:id/:post_type',(req, res,err)=>{
				var Postid=req.params.id;var res_send={};
				var Posttype=req.params.post_type;
				var Mailgun_Lib = new MailgunLib();
					if(env('APP_ENV')=="development" || env('APP_ENV')=="test")
				{
				var list_Objects=[
				{"name": "Veera", "address": "veeramani.kamaraj@japanmacroadvisors.com"},
				{"name": "Sadia", "address": "sadia.siddiqa@japanmacroadvisors.com"},
				{"name": "Vinesh", "address": "vigneswaran.sekar@japanmacroadvisors.com"}
				]
				
				var usersCount = list_Objects.length;
				}else{
				var usersCount = Mailgun_Lib.getCountofEmailAlertMembers();
				}
 				//console.log(usersCount)
	 
Mailgun_Lib.fetchPostData(Postid,function(err,rows){ console.log('fetchPostData');
				var postData=JSON.parse(JSON.stringify(rows))
				var postTitle =indicatorName= (postData[0]['post_title']);
				var postId = (postData[0]['post_id']);
				var postCategory_id = postData[0]['post_category_id'];
				var mail_code = 'Indicator_update_notification';
				var category_path=Mailgun_Lib.getAllParentCategoriesByCategoryId(postCategory_id);
				var postURL=category_path+'/'+postData[0]['post_url'];
				var postDesc  = postData[0]['post_cms'];
				postDesc=postDesc.substring(postDesc.search("Recent Data Trend"),postDesc.search("Brief")); 
				var post_head =mailSubject= postData[0]['post_heading'];
				var link = env('APP_URL')+'/reports/view/'+postURL; console.log(link);

				if(Posttype=='N')
				var postDesc = postData[0]['short_desc'];

				if(Posttype=='N')
				var mail_code = 'Indicator_update_news';

				Mailgun_Lib.selectMailTemplate(mail_code,function(err,rows){
				var mailTemplate=JSON.parse(JSON.stringify(rows))
				var template  = mailTemplate[0].email_templates_message;
				var Othr_Obj ={
					"Recent Data Trend :" :'', 
					"Brief" : '',
					"Recent Data Trend:" :'',
					"Recent Data Trend" :'',
					"http://" :'',
					"https://" :''
				};
				var RE_ = new RegExp(Object.keys(Othr_Obj).join("|"), "gi");
	             postDesc = postDesc.replace(RE_, function(matched) { 
	                return Othr_Obj[matched]; 
	            });

				var Str_Obj = {
				"{name}"   :"<b>%recipient%</b>", 
				"{post_title}"  :postTitle,
				"{post_heading}"  :post_head,  
				"{recent_data_trend}":postDesc,
				"{link}"   :link,
				"{userEmail}":"<b>%recipient_email%</b>"
				};
				
				
				var RE = new RegExp(Object.keys(Str_Obj).join("|"), "gi"); 
	            var mailBody = template.replace(RE, function(matched) { 
	                return Str_Obj[matched]; 
	            }); //console.log(mailBody);

	            var Mail_Obj = {
				"postId"   :postId, 
				"indicatorName"  :indicatorName,
				'mailSubject':mailSubject,
				"mailBody"  :mailBody  
				
				};
				 
				Mailgun_Lib.createNewList(Mail_Obj,usersCount,list_Objects);
				}); 

				res_send.success='Successfully sent email!'; 
				res.send((res_send));
				});


});
//publish-the-post and send email

router.get('/publish-the-post/:id/:status/:post_type',(req, res,err)=>{
	var Postid=req.params.id; var res_send={};
	var Poststatus=req.params.status;
	var Posttype=req.params.post_type;
	
	var Mailgun_Lib = new MailgunLib();
	Mailgun_Lib.changeStatus(Postid,Poststatus,function(err,affectedRows){
		if(affectedRows){ console.log('changeStatus')
			Mailgun_Lib.fetchPostData(Postid,function(err,rows){ console.log('fetchPostData')
				var postData=JSON.parse(JSON.stringify(rows))
				var post_publish_status=postData[0].post_publish_status;
				var post_mail_notification=postData[0].post_mail_notification;

				if(Mailgun_Lib.checkAlreadysent(Posttype,post_publish_status,post_mail_notification)){ console.log('checkAlreadysent')
					var postTitle=mailSubject = (postData[0]['post_title']);
					var postCategory_id = postData[0]['post_category_id'];
					var category_path=Mailgun_Lib.getAllParentCategoriesByCategoryId(postCategory_id);
					var postDesc  = postData[0]['post_cms_small'];
					var postURL=category_path+postData[0]['post_url'];
					var innerTeammsgOut= "***************** SendNewPostNotification - START <br><br>";
					 innerTeammsgOut+= '******* New Post identified : '+postTitle+"<br>";
					var link = env('APP_URL')+'/reports/view/'+postURL; console.log(link);
					innerTeammsgOut+= '******* New URL identified : '+link+"<br>";

					
										Mailgun_Lib.selectMailTemplate('Breaking_new',function(err,rows){
										var mailTemplate=JSON.parse(JSON.stringify(rows))
										var template  = mailTemplate[0].email_templates_message;
										var Str_Obj = {
										"{{name}}"   :"<b>%recipient%</b>", 
										"{{Title}}"  :postTitle, 
										"{{Summary}}":postDesc,
										"{{Link}}"   :link,
										"{userEmail}":"<b>%recipient_email%</b>"
										};
										
										var RE = new RegExp(Object.keys(Str_Obj).join("|"), "gi"); 
							            var mailBody = template.replace(RE, function(matched) { 
							                return Str_Obj[matched]; 
							            });
												//console.log(mailBody);
										Mailgun_Lib.updatePostMailNotification(Postid);
										Mailgun_Lib.sendPostMailNotification(mailSubject,mailBody);
										}); //failed,rejected
										var queryObj = {
													'subject'        : mailSubject,
													'tags'           : Mailgun_Lib.timestamp,
													'event'          : 'failed'   
												};
											setTimeout(function(){
											    Mailgun_Lib.sendEventInfo(queryObj,postTitle);
											}.bind(Mailgun_Lib), 10000);
										innerTeammsgOut+= "<br>***************** SendNewPostNotification - END <br><br>";
										Mailgun_Lib.sendMailGunStatus(innerTeammsgOut,"Send new post notification - MailGun status");

										res_send.success='Published and sent emails also!'; 
										res.send((res_send));
										
										
										
										

				}else{
					
					res_send.error='Already published and sent emails also! Do you wnat to send again'; 
					res.send((res_send));
					
				}
	
			
			});
		}else{
					
					res_send.error='Something troubling changing status of post publish status'; 
					res.send((res_send));
					
				}
		
	});
	
		
//res.send(path.join(__dirname, '../lib/MailgunLib'));
	
});

module.exports = router;
