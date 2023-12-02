const { check,validationResult }= require('express-validator');
//Get Graph data
router.get('/getEmailTemplates',(req, res,err)=>{
	con.query('SELECT * FROM '+emailTemplates_table, (err, rows, fields) => {
		if (!err)
		res.send(rows);
		else {
			console.log(err);
			res.send({err_code:"manual",message:getError});
		}
	})
});

//Insert Graph data
router.post('/insertEmailTemplates',[check('email_templates_code').isLength({min:1}),check('email_templates_subject').isLength({min:2}),check('email_templates_variable').isLength({min:2}),check('email_templates_message').isLength({min:10})],(req, res,err)=>{
	const errors = validationResult(req)
	if (!errors.isEmpty()) {
		return res.send({err_code:"manual",message:validationError});
	}
	con.query('INSERT INTO '+emailTemplates_table+' SET ?',req.body, (err, rows, fields) => {
		if (!err){
		console.log("Inserted successfully");
		res.send("Inserted successfully");
		} else {
			console.log(err);
			res.send({err_code:"manual",message:insertError});
		}
	})	
});

//Get email data
router.post('/getEditEmailTemplates',(req, res,err)=>{
	con.query('SELECT * FROM '+emailTemplates_table+' WHERE email_templates_id ='+req.body.email_id, (err, rows, fields) => {
		if (!err){
			res.send(rows);
		} else {
			console.log(err);
			res.send({err_code:"manual",message:getError});
		}
	})
	
});

//Update Email data
router.post('/updateEmailTemplates',[check('email_templates_code').isLength({min:1}),check('email_templates_subject').isLength({min:2}),check('email_templates_variable').isLength({min:2}),check('email_templates_message').isLength({min:10})],(req, res,err)=>{
	const errors = validationResult(req)
	if (!errors.isEmpty()) {
		return res.send({err_code:"manual",message:validationError});
	}
	con.query('UPDATE '+emailTemplates_table+' SET ? WHERE email_templates_id = '+req.body.email_templates_id,req.body, (err, rows, fields) => {
		if (!err){
			console.log("Updated successfully");
			res.send("Updated successfully");
		} else {
			console.log(err);
			res.send({err_code:"manual",message:updateError});
		}
	})	
});

//Delete email data
router.post('/deleteEmailTemplates',(req, res,err)=>{
	con.query('DELETE from '+emailTemplates_table+' WHERE email_templates_id = '+req.body.id, (err, rows, fields) => {
		if (!err){
			console.log("Deleted successfully");
			res.send("Deleted successfully");
		}	else {
			console.log(err);
			res.send({err_code:"manual",message:deleteError});
		}
	})	
});
module.exports = router;
