'user strict';

//Home object constructor

var HomeModel = function (obj) {
    this.title = obj.title;
    this.description = obj.description;
    this.published_date = obj.published_date;
    this.report_link = obj.report_link;
    this.graph_code = obj.graph_code;
}

HomeModel.fetch = function (result) {
   
    sql.query("SELECT * FROM homepage_graph order by id desc limit 1", function (err, res) {
         
        if (err) {
            console.log("error: ", err);
            result(null, err);
        } else {

            result(null, res);
            console.log("SELECT * FROM homepage_graph order by id desc limit 1");
        }
    });
  
};



HomeModel.getlatestnewsitems = function (count, result) {
    //console.log(email);
    sql.query("SELECT p.post_id,p.post_category_id,p.post_released,p.post_type,p.post_url,p.post_title,p.post_heading,p.post_subheading,p.post_cms_small,p.post_cms,"+
        "pc.post_category_id,hg.id FROM post p LEFT JOIN post_category pc ON p.post_category_id = pc.post_category_id INNER JOIN homepage_graph hg ON p.post_title!=hg.title WHERE  p.post_publish_status ='Y'  AND hg.title IS NOT NULL  ORDER BY STR_TO_DATE(p.`post_released`,'%M %d, %Y') DESC LIMIT 0,"+count,  function (err, res) {
         //sql.end();
          if (err) {
            console.log("error: ", err);
            result(err, null);
        } else {
            result(null, res);
        }
    });
};
//not used
HomeModel.getAllParentCategoriesByCategoryId=function(postCatId,result){
      
        var query_ = "CALL getAllParentCategoriesByCategoryId(" + postCatId + ")";
        var rows=sql.query(query_,function (err, res) {
        //  sql.end();
       if (err) {
            console.log("error: ", err);
            result(err, null);
        } else {
            result(null, res);
        } 
        });
    }

HomeModel.getAllParentCategoriesByCategoryId1=function(postCatId){
        var urlstring='';
        var query_ = "CALL getAllParentCategoriesByCategoryId(" + postCatId + ")";
        var rows=Sync_MySqlcon.query(query_);
          
        if(rows.length)  {
            var results=(JSON.parse(JSON.stringify(rows)))[0];
            var urlstring=results.map(function(el){ return el.category_url; }).join('/');
           // console.log(urlstring);   
            
        }
         return (urlstring);   
       
    }
//not used
HomeModel.getCategotyArrayParsedIntoPath=function(cat_array) {
        var response = '';
        /*if(is_array(cat_array)) {
            foreach (cat_array as rw_cat) {
                response+=$rw_cat['category_url'].'/';
            }
        }*/
        return response;
    }


module.exports = HomeModel;