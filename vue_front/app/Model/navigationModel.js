'user strict';

//User object constructor
var NavigationModel = function (creUSer) {

}
NavigationModel.fetch = function (result) {
    sql.query('SELECT category_group,category_url,post_category_parent_id,post_category_id,post_category_name FROM post_category WHERE post_category_status = "Y" order by category_order asc', (err, rows) => {
        if (!err) {
            result(null, rows);
        } else {
            console.log(err);
            res.send({
                err_code: "manual",
                message: "get error"
            });
        }
    })


};

module.exports = NavigationModel;