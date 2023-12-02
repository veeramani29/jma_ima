//Get User data
router.get('/getArchive',(req, res,err)=>{
	con.query('SELECT * FROM '+archive_table, (err, rows, fields) => {
		if (!err) {
			res.send(rows);
		} else {
			console.log(err);
			res.send({err_code:"manual",message:getError});
		}
	})
});

//Get edit Company data
router.post('/getEditArchive',(req, res,err)=>{
	con.query('SELECT * FROM '+archive_table+' WHERE id ='+req.body.archive_id, (err, rows, fields) => {
		if (!err)
			res.send(rows);
		else {
			console.log(err);
			res.send({err_code:"manual",message:getError});
		}
	})
});

//Update Company data
router.post('/updateArchive',(req, res,err)=>{
	con.query('UPDATE '+archive_table+' SET ? WHERE id = '+req.body.id,req.body, (err, rows, fields) => {
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
router.post('/deleteArchive',(req, res,err)=>{
	con.query('DELETE from '+archive_table+' WHERE id = '+req.body.id, (err, rows, fields) => {
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
