const { check,validationResult }= require('express-validator');
//Get media data
router.get('/getMedia',(req, res,err)=>{
	con.query('SELECT * FROM '+media_table, (err, rows, fields) => {
		if (!err)
			res.send(rows);
		else {
			res.send({err_code:"manual",message:getError});
			console.log(err);
		}
	})
});

//Insert media data
router.post('/insertMedia',[check('media_value_text').isLength({min:2}),check('media_sort').isNumeric()],(req, res,err)=>{
	const errors = validationResult(req)
	if (!errors.isEmpty()) {
		return res.send({err_code:"manual",message:validationError});
	}
	con.query('INSERT INTO '+media_table+' SET ?',req.body, (err, rows, fields) => {
		if (!err){
			console.log("Inserted successfully");
			res.send("Inserted successfully");
		} else {
			console.log(err);
			res.send({err_code:"manual",message:insertError});
		}
	})	
});

//Get edit Media data
router.post('/getEditMedia',(req, res,err)=>{
	con.query('SELECT * FROM '+media_table+' WHERE media_id ='+req.body.media_id, (err, rows, fields) => {
		if (!err)
			res.send(rows);
		else {
			console.log(err);
			res.send({err_code:"manual",message:getError});
		}
	})
});

//Update Media data
router.post('/updateMedia',[check('media_value_text').isLength({min:2}),check('media_sort').isNumeric()],(req, res,err)=>{
	const errors = validationResult(req)
	if (!errors.isEmpty()) {
		return res.send({err_code:"manual",message:validationError});
	}
	con.query('Update '+media_table+' SET ? WHERE media_id = '+req.body.media_id,req.body, (err, rows, fields) => {
		if (!err){
			console.log("Updated successfully");
			res.send("Updated successfully");
		}else {
			console.log(err);
			res.send({err_code:"manual",message:updateError});
		}
	})	
});

//Delete media data
router.post('/deleteMedia',(req, res,err)=>{
	con.query('DELETE from '+media_table+' WHERE media_id = '+req.body.id, (err, rows, fields) => {
		if (!err){
			console.log("Deleted successfully");
		res.send("Deleted successfully");
		}else {
			console.log(err);
			res.send({err_code:"manual",message:deleteError});
		}
	})	
});
module.exports = router; 
