const { check,validationResult }= require('express-validator');
//Get User data
router.get('/getUser',(req, res,err)=>{
	con.query('SELECT u.id,u.user_title,u.registered_on,u.fname,u.lname,u.email,u.user_post_alert,ut.type_name,us.status_name,u.expiry_on FROM '+user_table+' u JOIN '+userType_table+' ut ON u.user_type_id=ut.id JOIN ' +userStatus_table+ ' us ON u.user_status_id = us.id', (err, rows, fields) => {
		if (!err) {
			res.send(rows);
		} else {
			console.log(err);
		}
	})
});

//Get User Types data
router.get('/getUserType',(req, res,err)=>{
	con.query('SELECT * FROM '+userType_table, (err, rows, fields) => {
		if (!err) {
			res.send(rows);
		} else {
			console.log(err);
		}
	})
});

//Get User country data
router.get('/getUserCountry',(req, res,err)=>{
	con.query('SELECT * FROM '+country_table, (err, rows, fields) => {
		if (!err) {
			res.send(rows);
		} else {
			console.log(err);
		}
	})
});

//Get User Status data
router.get('/getUserStatus',(req, res,err)=>{
	con.query('SELECT * FROM '+userStatus_table, (err, rows, fields) => {
		if (!err) {
			res.send(rows);
		} else {
			console.log(err);
		}
	})
});

//Insert User data
router.post('/insertUser',[check('password').isLength({min:5}),check('fname').isLength({min:3}),check('lname').isLength({min:3}),check('user_title').isLength({min:1}),check('email').isEmail()],(req, res,err)=>{
	const errors = validationResult(req)
	if (!errors.isEmpty()) {
		return res.send({err_code:"manual",message:validationError});
	}
	con.query('INSERT INTO '+user_table+' SET ?',req.body, (err, rows, fields) => {
		if (!err){
			console.log("Inserted successfully");
			res.send("Inserted successfully");
		} else {
			console.log(err);
			res.send({err_code:"manual",message:insertError});
		}
	})	
});

//Get edit User data
router.post('/getEditUser',(req, res,err)=>{
	con.query('SELECT u.id,u.user_title,u.expiry_on,u.phone,u.email_verification,u.company_id,u.country_id,u.user_type_id,u.user_status_id,u.password,u.user_title,u.fname,u.lname,u.email,u.user_post_alert FROM '+user_table+' u  WHERE u.id ='+req.body.user_id, (err, rows, fields) => {
		if (!err){
			res.send(rows);
		} else {
			console.log(err);
			res.send({err_code:"manual",message:getError});
		}
	})
	
});

//Update User data
router.post('/updateUser',[check('password').isLength({min:5}),check('fname').isLength({min:3}),check('lname').isLength({min:3}),check('user_title').isLength({min:1}),check('email').isEmail()],(req, res,err)=>{
	const errors = validationResult(req)
	if (!errors.isEmpty()) {
		return res.send({err_code:"manual",message:validationError});
	}
	con.query('UPDATE '+user_table+' SET ? WHERE id = '+req.body.id,req.body, (err, rows, fields) => {
		if (!err){
			console.log("Updated successfully");
			res.send("Updated successfully");
		} else {
			console.log(err);
			res.send({err_code:"manual",message:updateError});
		}
	})	
});


//Delete User data
router.post('/deleteUser',(req, res,err)=>{
	con.query('DELETE from '+user_table+' WHERE id = '+req.body.id, (err, rows, fields) => {
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
