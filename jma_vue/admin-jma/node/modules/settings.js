const MemcachedLib = require(path.join(__dirname, '../lib/MemcachedLib'));
//Change password
router.post('/changePassword',(req, res,err)=>{
	var passwordPortion = req.session.Users.substring(req.session.Users.search('password'), req.session.Users.search('}'));
	var passwordSplit =passwordPortion.split('"');
	var idPortion = req.session.Users.substring(req.session.Users.search('admin_id'), req.session.Users.search(','));
	var idSplit =idPortion.split('"') ;
	const admin_id = idSplit[1].substr(1);
	if(passwordSplit[2] == md5(req.body.oldPassword)){
		con.query('UPDATE '+admin_table+' SET password ="'+md5(req.body.password)+'" WHERE admin_id = '+admin_id, (err, rows, fields) => {
			if (!err){
				console.log("Password Updated successfully");
				res.send("Password Updated successfully");
			} else {
				console.log(err);
				res.send({err_code:"manual",message:updateError});
			}
		})
	} else {
		res.send({err_code:"manual",message:"Incorrect old password"});
	}	
});

//Get media data
router.get('/getIPAddress',(req, res,err)=>{
	con.query('SELECT * FROM '+ip_table, (err, rows, fields) => {
		if (!err)
			res.send(rows);
		else {
			res.send({err_code:"manual",message:getError});
			console.log(err);
		}
	})
});

//Insert media data
router.post('/insertIPAddress',(req, res,err)=>{
	con.query('UPDATE '+ip_table+' SET ? WHERE id = '+req.body.id,req.body, (err, rows, fields) => {
		if (!err){
			console.log("Updated successfully");
			res.send("Updated successfully");
		} else {
			console.log(err);
			res.send({err_code:"manual",message:updateError});
		}
	})	
});

//Memcahe settings
//Get all cache items
router.get('/getallkeys',(req, res,err)=>{
	var Memcached_Lib = new MemcachedLib();
	Memcached_Lib.readKeys(function(rows){
	res.send(rows);
	});
	
		
	});
	//delete all cache items
	router.get('/deleteallkeys',(req, res,err)=>{
	var Memcached_Lib = new MemcachedLib();
	Memcached_Lib.flushKeys();
	res.send({message:'successfully deleted all keys'});	
	});
module.exports = router; 