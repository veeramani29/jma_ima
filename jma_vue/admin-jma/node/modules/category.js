const {
	check,
	validationResult
} = require('express-validator');
//Get edit post data
router.post('/getEditCategoryData', (req, res, err) => {
	con.query('SELECT * FROM ' + postCategory_table + ' WHERE post_category_id =' + req.body.category_id, (err, rows, fields) => {
		if (!err) {
			res.send(rows);
		} else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: getError
			});
		}
	})
});

//Get post categories
router.get('/getCategory', (req, res, err) => {
	con.query('SELECT * FROM ' + postCategory_table, (err, rows, fields) => {
		if (!err) {
			// console.log(rows);
			res.send(rows);
		} else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: getError
			});
		}
	})
});

//Get main categories
router.get('/getMainCategory', (req, res, err) => {
	con.query('SELECT post_category_id,post_category_name FROM ' + postCategory_table + ' WHERE post_category_parent_id = 0', (err, rows, fields) => {
		if (!err) {
			// console.log(rows);
			res.send(rows);
		} else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: getError
			});
		}
	})
});

//Get main categories
router.post('/getSubCategory', (req, res, err) => {
	con.query('SELECT post_category_id,post_category_name FROM ' + postCategory_table + ' WHERE post_category_parent_id = ' + req.body.id, (err, rows, fields) => {
		if (!err) {
			res.send(rows);
		} else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: getError
			});
		}
	})
});

//Insert post data
router.post('/addCategory', [check('post_category_name').isLength({
	min: 2
})], (req, res, err) => {
	const errors = validationResult(req)
	if (!errors.isEmpty()) {
		return res.send({
			err_code: "manual",
			message: validationError
		});
	}
	con.query('INSERT INTO ' + postCategory_table + ' SET ?', req.body, (err, rows, fields) => {
		if (!err) {
			console.log("Inserted successfully");
			res.send({
				message: 'Inserted successfully'
			});
		} else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: insertError
			});
		}
	})
});

//Update category data
router.post('/updateCategory', [check('post_category_name').isLength({
	min: 2
})], (req, res, err) => {
	const errors = validationResult(req)
	if (!errors.isEmpty()) {
		return res.send({
			err_code: "manual",
			message: validationError
		});
	}
	con.query('Update ' + postCategory_table + ' SET ? WHERE post_category_id = ' + req.body.post_category_id, req.body, (err, rows, fields) => {
		if (!err) {
			console.log("Updated successfully");
			res.send("Updated successfully");
		} else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: updateError
			});
		}
	})
});

//Update Category Status
router.post('/updateCategoryStatus', (req, res, err) => {
	con.query('Update ' + postCategory_table + ' SET ? WHERE post_category_id = ' + req.body.post_category_id, req.body, (err, rows, fields) => {
		if (!err) {
			console.log("Category Status Updated successfully");
			res.send("Category Status Updated successfully");
		} else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: updateError
			});
		}
	})
});

//Update Icon Status
router.post('/updateCategoryIconStatus', (req, res, err) => {
	con.query('Update ' + postCategory_table + ' SET ? WHERE post_category_id = ' + req.body.post_category_id, req.body, (err, rows, fields) => {
		if (!err) {
			console.log("Category Icon Status Updated successfully");
			res.send("Category Icon Status Updated successfully");
		} else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: updateError
			});
		}
	})
});

//Update Category Order
router.post('/updateCategoryOrder', (req, res, err) => {
	con.query('Update ' + postCategory_table + ' SET ? WHERE post_category_id = ' + req.body.post_category_id, req.body, (err, rows, fields) => {
		if (!err) {
			console.log("Category Order Updated successfully");
			res.send("Category Order Updated successfully");
		} else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: updateError
			});
		}
	})
});

//Delete category 
router.post('/deleteCategory', (req, res, err) => {
	con.query('DELETE from ' + postCategory_table + ' WHERE post_category_id = ' + req.body.id, (err, rows, fields) => {
		if (!err) {
			console.log("Deleted successfully");
			res.send("Deleted successfully");
		} else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: deleteError
			});
		}
	})
});
module.exports = router;