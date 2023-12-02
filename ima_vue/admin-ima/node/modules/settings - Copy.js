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
	var rows=[ 'chartdata_0f53d8914dc420a1b309fe721a7f35a69d30aad1',
  'chartdata_1ead98e0c61e63331471fe3e126dc7d9a736cb56',
  'chartdata_193c13a0cebfbe204a89342f25ec84b001dad363',
  'chartdata_b618b5169e098c8115591fd0d1b7f17dd4754fe7',
  'chartdata_95f74e1c5c11afef5f0cbf802fc22d4e70f27716',
  'chartdata_41a06de2501ddf34ab27d9b65b07eda5382ff2b4',
  'chartdata_98459e67c627c5bc3a10f2b4d902f09d0f6860e3',
  'chartdata_e4ae2b1e6260e130e67ec8b3d10a771f96cb7f86',
  'chartdata_6492a900e3f5d9c99f728b1d918130a3ea373c50',
  'chartdata_e7a952ff5a7437e226017ec74e21e855f3dd56b5',
  'chartdata_9aab1539952484cba9237c1520245e72774a51e2',
  'chartdata_f3655a4a7b40963ff5165b04b00031f303b6c4e3',
  'chartdata_200a53003ae34e15ea66c2297637e0895568f243' ];

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