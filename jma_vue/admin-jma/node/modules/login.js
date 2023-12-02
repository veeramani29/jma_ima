//Get login data
router.post('/login',(req, res,err)=>{
	con.query('SELECT * FROM '+admin_table+' WHERE user = "'+req.body.user+'" AND password = "'+md5(req.body.password)+'"', (err, rows, fields) => {
        if (!err && rows.length != 0){
            console.log("Login Successfully");
            var admin_data=rows;
            var admin_data_=admin_data[0];
            delete admin_data_.password;
            req.session.Users = JSON.stringify(admin_data_);
            req.session.save();

                let token = jwt.sign({ id: admin_data_.admin_id }, 'INDIAmacroADVISORS-secret', {expiresIn: 86400 });
                res.status(200).send({ auth: true, token: token, admin_data: admin_data_ });
               
        }else{
            console.log("Login failed");
            req.session.destroy();
            res.send({err_code:"manual",message:loginError});
        }
	})
});

//Destroy Session
router.get('/sessionDestroy',(req, res,err)=>{
   if (req.session.Users && Object.keys(req.session.Users).length) {
     req.session.destroy();
   }
   
    console.log("Session Destroyed");
    res.send("Session Destroyed");
});

//Get login data

module.exports = router;