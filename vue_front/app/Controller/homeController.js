'use strict';

var HomeModel = require('../Model/homeModel.js');
var Media = require('../Model/mediaModel.js');
var Common = require('../Lib/Common.js');
var Media = new Media();
var Common = new Common();
exports.getHomepageGraph = function(req, res) {

  

  HomeModel.fetch(function(err, result) {
    if (err)
      res.send(err);
    var str=new Buffer( result[0].graph_code, 'binary' ).toString('utf8')+'veera mani sdrere {graph_narrow 30-2||2014-06,2018-08}';
   Common.makeChart(str);
    //
    res.json(result);
  });
};


exports.getLatestNewsItems = async function(req, res) {


  HomeModel.getlatestnewsitems(5, function(err, results) {
    if (err)
      res.send(err);

    results.forEach(function(element,index){ 
     var urlstring=HomeModel.getAllParentCategoriesByCategoryId1(element.post_category_id);
		console.log(urlstring);
    Object.assign(results[index],{category_path:urlstring}); 
    });
   
    res.json(results); 
  });
};



/*(async () => { 
   const rows = await sqlPro.execute("SELECT * FROM homepage_graph order by id desc limit 1");
    console.log(rows[0]);

})();*/





