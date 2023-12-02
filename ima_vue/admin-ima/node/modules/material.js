//Get material data
router.get('/getMaterial',(req, res,err)=>{
	con.query('SELECT * FROM '+material_table, (err, rows, fields) => {
		if (!err)
			res.send(rows);
		else {
			console.log(err);
			res.send({err_code:"manual",message:getError});
		}
	})
});

//Insert material data
router.post('/insertMaterial',(req, res,err)=>{
	con.query('INSERT INTO '+material_table+' SET ?',req.body, (err, rows, fields) => {
		if (!err){
			console.log("Inserted successfully");
			res.send("Inserted successfully");
		} else {
			console.log(err);
			res.send({err_code:"manual",message:insertError});
		}
	})	
});
module.exports = router;
