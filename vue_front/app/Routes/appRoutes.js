'use strict';
module.exports = function (app) {
	var signup = require('../Controller/userController');
	var navigation = require('../Controller/navigationController');

	var home = require('../Controller/homeController');

	// var socialLogin = require('../Controller/socialLoginController');


	// todoList Routes
	app.route('/countryData/:qry').get(signup.countryList);
	app.route('/sectorData/:qry').get(signup.industryList);
	app.route('/jobData/:qry').get(signup.positionList);
	app.route('/register-submit').post(signup.create_user);
	app.route('/login-submit').post(signup.user_login);
	app.route('/categoryList').get(navigation.categoryList);
	app.route('/defaultIndicators').get(signup.defaultAlerts);
	app.route('/registeredData/:qry').get(signup.getLastRegUser);
	// app.route('/saveFile/').post(signup.saveFile);
	app.post('/saveFile', upload.single('UploadFiles'), (req, res, err) => {
		res.send(req.file);
	});
	app.post('/sendResume', (req, res, err) => {
		fs.readFile(req.body.path, function (err, data) {
			transporter.sendMail({       
				from: 'veeramani.kamaraj@japanmacroadvisors.com',
				to: 'vigneswaran.sekar@japanmacroadvisors.com',
				subject: 'Resume!',
				body: 'mail content...',
				attachments: [{'filename': req.body.name, 'content': data}]
			}), function(err, success) {
				if (err) {
					console.log(err)
					res.send({
						err_code: "manual",
						message: postError
					});
					// Handle error
				} else {
					console.log(success)
				}
		
			}
		});
		res.send("mail sent");
	});
	


	app.route('/gethomepagegraph').get(home.getHomepageGraph);
	app.route('/latest').get(home.getLatestNewsItems);

	// app.route('/linkedin').get(socialLogin.linkedin);
	// app.route('/facebook').get(socialLogin.facebook);
 
};