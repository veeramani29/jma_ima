const {
	check,
	validationResult
} = require('express-validator');
//Get map data
router.get('/getMap', (req, res, err) => {
	con.query('SELECT * FROM ' + mapDetails_table, (err, rows, fields) => {
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

//Get map data
router.post('/getMapView', (req, res, err) => {
	con.query('SELECT vid,gid,y_value,y_sub_value,min(vid) FROM ' + mapValues_table + ' WHERE gid =' + req.body.map_id + ' GROUP BY y_value, y_sub_value order by min(vid)', (err, rows, fields) => {
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

//Get edit map data
router.post('/getEditMap', (req, res, err) => {
	con.query('SELECT * FROM ' + mapDetails_table + ' WHERE gid =' + req.body.map_id, (err, rows, fields) => {
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
router.post('/xlstojsonMap', function (req, res) {
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
			var mapData = {
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
			con.query('INSERT INTO ' + mapValues_table + ' SET ?', mapData, (err, result) => {
				if (!err) {
					// console.log("Inserted successfully");
				} else
					console.log(err);
				// res.send(graphData);
			})
		}
	}
	console.log("inserted successfully");
	res.send("inserted successfully");
});

//Insert map data
router.post('/insertMap', [check('source').isLength({
	min: 2
}), check('title').isLength({
	min: 2
}), check('filepath').isLength({
	min: 5
})], (req, res, err) => {
	con.query('INSERT INTO ' + mapDetails_table + ' SET ?', req.body, (err, result) => {
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
router.post('/updateMap', (req, res, err) => {
	con.query('UPDATE ' + mapDetails_table + ' SET ? WHERE gid = ' + req.body.gid, req.body, (err, result) => {
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

//Delete map values data
router.post('/deleteMapvalues', (req, res, err) => {
	con.query('DELETE from ' + mapValues_table + ' WHERE gid = ' + req.body.id, (err, rows, fields) => {
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

//Delete map details data
router.post('/deleteMapDetails', (req, res, err) => {
	con.query('DELETE from ' + mapDetails_table + ' WHERE gid = ' + req.body.id, (err, rows, fields) => {
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