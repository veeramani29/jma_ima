global.express = require('express');
global.app = express();
global.cors = require('cors');
global.bodyParser = require('body-parser');
global.hat = require('hat');
global.appToken = hat()
global.mysql = require('mysql');
global.Sync_MySql = require('sync-mysql');
global.router = express.Router();
global.multer = require('multer');
global.path = require("path");
global.md5 = require('md5');
global.fs = require("fs");
global.session = require('express-session');
global.cookieParser = require('cookie-parser')
global.jwt = require('jsonwebtoken');

// global.xlsxtojson = require("xlsx-to-json");
// global.xlstojson = require("xls-to-json");
global.XLSX = require('xlsx');
// global.check,validationResult= require('express-validator');
// global.check,validationResult = require('express-validator');

global.apiHelper = require('./lib/apiHelper');
const dotenv = require('dotenv');
const result = dotenv.config({
	path: path.join(__dirname, '../.env')
});
const {
	parsed: env_variables
} = result;


global.env = function (para) {
	//console.log(env_variables[para]);
	if (env_variables[para] != '')
		return env_variables[para];
	else
		return '';
}
if (env('APP_ENV') != "development")
	global.saveFilePath = path.resolve(__dirname, './uploads/') + '/';
else
	global.saveFilePath = './uploads/';
global.VariousConfig = require('./config/environment/' + env('APP_ENV'));
global.insertError = "Insert Error";
global.updateError = "Update Error";
global.deleteError = "Delete Error";
global.getError = "Get Error";
global.loginError = "Invalid Username or Password";
global.validationError = "Required fields are incorrect";
//Mysql configuration
global.con = mysql.createConnection({
	host: env('DB_HOST'),
	user: env('DB_USERNAME'),
	password: env('DB_PASSWORD'),
	database: env('DB_DATABASE'),
	/*waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0*/
});

//Mysql Synchronous connection configuration
global.Sync_MySqlcon = new Sync_MySql({
	host: env('DB_HOST'),
	user: env('DB_USERNAME'),
	password: env('DB_PASSWORD'),
	database: env('DB_DATABASE'),
	/*waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0*/
});




con.connect(function (err) {
	if (err) throw err;
	console.log("Connected!");
});



//saving the file using multer
global.storage = multer.diskStorage({
	destination: (req, file, cb) => {
		cb(null, saveFilePath)
	},
	filename: (req, file, cb) => {
		global.uploadDate = Date.now();
		cb(null, uploadDate + file.originalname)
	}
})
global.upload = multer({
	storage: storage
});


global.post_table = "post";
global.archive_table = "archeive_post";
global.postCategory_table = "post_category";
global.copyWriter_table = "copywriter";
global.media_table = "media";
global.material_table = "material";
global.graphDetails_table = "graph_details";
global.graphValues_table = "graph_values";
global.mapDetails_table = "mapgraph_details";
global.mapValues_table = "map_values";
global.user_table = "user_accounts";
global.user_company_table = "user_company";
global.userType_table = "user_types";
global.userStatus_table = "user_statuses";
global.country_table = "country";
global.archive_table = "archeive_post";
global.emailTemplates_table = "email_templates";
global.admin_table = "admin";
global.ip_table = "ip_address";
global.homePage_graph_table = "homepage_graph";

module.exports = router;