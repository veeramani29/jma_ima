"use strict";
class Media {
    constructor(file) {
        this.db_ = Sync_MySqlcon;
         this.db = sql;
       
    }

   

    getLatestMediaAsNotice(limit,callback) {
        var qry='SELECT * FROM `media` where `media_notice`=1 order by `media_sort` asc, `media_date` desc limit 0,'+limit;
        return this.db.query(qry, function(err,rows){
            callback(err,rows)
        })
    }
    getLatestMedia(limit,callback) {
         var qry='SELECT * FROM `media` where `media_notice` =0 order by `media_sort` asc, `media_date` desc limit 0,'+limit;
        return this.db.query(qry, 
            function(err,rows){
            callback(err,rows)
        })
    }

   
}

module.exports = Media
