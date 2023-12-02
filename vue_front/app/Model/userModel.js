'user strict';

//User object constructor

var UserModel = function (creUSer) {
    this.fname = creUSer.fname;
    this.lname = creUSer.lname;
    this.title = creUSer.title;
    this.country = creUSer.country;
    this.email = creUSer.email;
}

UserModel.fetch = function (qry, task, result) {
    if (qry == 'country') {
        var qry_param1 = " ORDER BY country_name ASC";
    } else if (qry == 'user_industry') {
        var qry_param1 = " ORDER BY user_industry_value ASC";
    } else if (qry == 'user_position') {
        var qry_param1 = "";
    }
    sql.query("SELECT * FROM " + qry + "" + qry_param1 + "", function (err, res) {
        if (err) {
            console.log("error: ", err);
            result(null, err);
        } else {
            result(null, res);
            console.log("SELECT * FROM " + qry + "" + qry_param1 + "");
        }
    });
};

UserModel.createUser = function (newUser, result) {
    sql.query("INSERT INTO `user_accounts` set ?", newUser, function (err, res) {

        if (err) {
            console.log("error: ", err);
            result(err, null);
        } else {
            console.log(res.insertId);
            result(null, res.insertId);
        }
    });
};

UserModel.getUserByEmail = function (email, result) {
    //console.log(email);
    sql.query("Select * from user_accounts where email = ? ", email, function (err, res) {
        if (err) {
            console.log("error: ", err);
            result(err, null);
        } else {
            result(null, res);
        }
    });
};

UserModel.loginSubmit = function (loginDetails, result) {
    console.log(loginDetails);
};

UserModel.defaultEmailAlert = function (result) {
    //console.log(email);
    sql.query("SELECT post_category_id FROM post_category WHERE default_email_alert = 'Y' AND `post_category_status` = 'Y'", function (err, res) {
        if (err) {
            console.log("error: ", err);
            result(err, null);
        } else {
            result(null, res);
        }
    });
};

UserModel.getUserData = function (id, task, result) {
    //console.log(email);
    sql.query("SELECT fname,lname,email,user_type_id,user_status_id,expiry_on FROM user_accounts WHERE id= ? ", id, function (err, res) {
        if (err) {
            console.log("error: ", err);
            result(err, null);
        } else {
            result(null, res);
        }
    });
};

module.exports = UserModel;