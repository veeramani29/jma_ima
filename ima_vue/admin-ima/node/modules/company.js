//Get User data
router.get('/getCompany',(req, res,err)=>{
	con.query('SELECT * FROM '+user_company_table, (err, rows, fields) => {
		if (!err) {
		res.send(rows);
		} else {
			console.log(err);
			res.send({err_code:"manual",message:getError});
		}
	})
});

//Get edit Company data
router.post('/getEditCompany',(req, res,err)=>{
	con.query('SELECT * FROM '+user_company_table+' WHERE id ='+req.body.company_id, (err, rows, fields) => {
		if (!err)
			res.send(rows);
		else {
			console.log(err);
			res.send({err_code:"manual",message:getError});
		}
	})
});

//Insert Company data
router.post('/insertCompany',(req, res,err)=>{
	con.query('INSERT INTO '+user_company_table+' SET ?',req.body, (err, rows, fields) => {
		if (!err){
			console.log("Inserted successfully");
			res.send("Inserted successfully");
		} else {
			console.log(err);
			res.send({err_code:"manual",message:insertError});
		}
	})
});

//Update Company data
router.post('/updateCompany',(req, res,err)=>{
	con.query('UPDATE '+user_company_table+' SET ? WHERE id = '+req.body.id,req.body, (err, rows, fields) => {
		if (!err){
			console.log("Updated successfully");
			res.send("Updated successfully");
		} else {
			console.log(err);
			res.send({err_code:"manual",message:updateError});
		}
	})
});


//Delete Company data
router.post('/deleteCompany',(req, res,err)=>{
	con.query('DELETE from '+user_company_table+' WHERE id = '+req.body.id, (err, rows, fields) => {
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
