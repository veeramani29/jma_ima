const {
	check,
	validationResult
} = require('express-validator');

//*************** Home page graph Start ***************
//Get Home Page Graph data
router.get('/getHomePageGraph', (req, res, err) => {
	con.query('SELECT * FROM ' + homePage_graph_table, (err, rows, fields) => {
		if (!err)
			res.send(rows);
		else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: getError
			});
		}
	})
});

//Update Home Page Graph data
router.post('/updateHomePageGraph', [check('title').isLength({
	min: 2
}), check('description').isLength({
	min: 2
}), check('graph_code').isLength({
	min: 5
}), check('report_link').isLength({
	min: 2
}), check('published_date').isLength({
	min: 2
})], (req, res, err) => {
	const errors = validationResult(req)
	if (!errors.isEmpty()) {
		return res.send({
			err_code: "manual",
			message: validationError
		});
	}
	var test = con.query('UPDATE ' + homePage_graph_table + ' SET ? WHERE id = "' + req.body.id + '"', req.body, (err, result) => {
		if (!err) {
			console.log("Home Page Graph Updated successfully");
			res.send(result);
		} else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: updateError
			});
		}
	})
	console.log(test.sql);
});
/************  Home page graph End  ****************/

//Get Graph data
router.get('/getGraph', (req, res, err) => {
	con.query('SELECT * FROM ' + graphDetails_table, (err, rows, fields) => {
		if (!err)
			res.send(rows);
		else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: getError
			});
		}
	})
});

//Get Graph View data
router.post('/getGraphView', (req, res, err) => {
	con.query('SELECT vid,gid,y_value,y_sub_value,min(vid) FROM ' + graphValues_table + ' WHERE gid =' + req.body.graph_id + ' GROUP BY y_value, y_sub_value order by min(vid)', (err, rows, fields) => {
		if (!err)
			res.send(rows);
		else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: getError
			});
		}
	})
});

//Get edit Graph data
router.post('/getEditGraph', (req, res, err) => {
	con.query('SELECT * FROM ' + graphDetails_table + ' WHERE gid =' + req.body.graph_id, (err, rows, fields) => {
		if (!err)
			res.send(rows);
		else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: getError
			});
		}
	})
});

//Xls to Json conversion
router.post('/xlstojson', function (req, res) {
	var workbook = XLSX.readFile(saveFilePath + req.body.filepath);
	var sheet_name_list = workbook.SheetNames;
	var result = XLSX.utils.sheet_to_json(workbook.Sheets[sheet_name_list[0]]);
	var keys = Object.keys(result);
	for (var i = 1; i < keys.length; i++) {
		var index = keys[i];
		var date = result[index]["__EMPTY"];
		if (result[index]["__EMPTY"].toString().length != 4) {
			var fullDate = result[index]["__EMPTY"].split("/");
			var year = fullDate[0];
			if (fullDate[1])
				var month = fullDate[1];
			else
				var month = 0;
			if (fullDate[2])
				var day = fullDate[2];
			else
				var day = 0;
		} else {
			var year = result[index]["__EMPTY"];
			var day = 0;
			var month = 0;
		}

		var checkKey = [];
		for (var keyCheck in result[index]) {
			checkKey.push(keyCheck);
		}

		for (var mainKey in result[0]) {
			if (checkKey.includes(mainKey) == false) {
				// console.log("false");
				result[index][mainKey] = "";
			}
		}
		delete result[index]["__EMPTY"];
		for (var key in result[index]) {
			var graphData = {
				"gid": req.body.id,
				"x_value": date,
				"date": day,
				"month": month,
				"year": year.trim(),
				"y_value": key.replace(/\_\d$/, ''),
				"y_sub_value": result[0][key],
				"value": result[index][key],
				"data_row": result.length,
				"data_coloumn": Object.keys(result[index]).length,
			}
			con.query('INSERT INTO ' + graphValues_table + ' SET ?', graphData, (err, result) => {
				if (!err) {
					// console.log("Inserted successfully");
				} else
					console.log(err);
				// res.send(graphData);
			})
		}
	}
	console.log("graph values inserted successfully");
	res.send("inserted successfully");
});

//Save Graph Files in the server
router.post('/saveGraphFile', upload.single('image'), (req, res, err) => {
	console.log(req.file.path);
	res.json({
		"path": req.file.path
	});
});

//Insert Graph data
router.post('/insertGraph', [check('source').isLength({
	min: 2
}), check('title').isLength({
	min: 2
}), check('filepath').isLength({
	min: 5
})], (req, res, err) => {
	const errors = validationResult(req)
	if (!errors.isEmpty()) {
		return res.send({
			err_code: "manual",
			message: validationError
		});
	}
	con.query('INSERT INTO ' + graphDetails_table + ' SET ?', req.body, (err, result) => {
		if (!err) {
			console.log("Inserted successfully");
			res.send(result);
		} else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: insertError
			});
		}
	})
});

//Update Graph data
router.post('/updateGraph', [check('source').isLength({
	min: 2
}), check('title').isLength({
	min: 2
}), check('filepath').isLength({
	min: 5
})], (req, res, err) => {
	const errors = validationResult(req)
	if (!errors.isEmpty()) {
		return res.send({
			err_code: "manual",
			message: validationError
		});
	}
	con.query('UPDATE ' + graphDetails_table + ' SET ? WHERE gid = ' + req.body.gid, req.body, (err, result) => {
		if (!err) {
			console.log("Updated successfully");
			res.send(result);
		} else {
			console.log(err);
			res.send({
				err_code: "manual",
				message: updateError
			});
		}
	})
});

//Delete graph details data
router.post('/deleteGraphDetails', (req, res, err) => {
	con.query('DELETE from ' + graphDetails_table + ' WHERE gid = ' + req.body.id, (err, rows, fields) => {
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

//Delete graph values data
router.post('/deleteGraphvalues', (req, res, err) => {
	con.query('DELETE from ' + graphValues_table + ' WHERE gid = ' + req.body.id, (err, rows, fields) => {
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