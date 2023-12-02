'use strict';
var Memcached = require('memcached');
Memcached.config.poolSize = 25;
//maxExpiration,maxValue,maxKeySize
class MemcachedLib {

    constructor() {
        var server = env('memcached_server');
        var port = env('memcached_port');

        this.memcached = new Memcached([server + ':' + port], { retries: 10, retry: 10000, remove: true, failOverServers: ['192.168.0.103:11211','127.0.0.1:11211'] });

        this.memcached.connect(server + ':' + port, function(err, conn) {
            if (err) console.log(err);

            //console.log(conn.serverAddress);

        });

        this.timestamp = (new Date()).getTime();
    }

    // Fetch All keys
    readKeys(callback) {
    	var self=this;
        this.memcached.items(function(err, result) {
            var key_array = [];
            if (err)
                console.error(err);
            // for each server...
            result.forEach(function(itemSet) {
                var keys = Object.keys(itemSet); 
                // we don't need the "server" key, but the other indicate the slab id's
                keys.pop();

                // Here get key item's length
                var keys_length = keys.length;

                keys.forEach(function(stats) {
                    // get a cachedump for each slabid and slab.number
                    self.memcached.cachedump(itemSet.server, parseInt(stats),
                        parseInt(itemSet[stats].number),
                        function(err, response) {
                            // memcached.end();
                            // dump the shizzle
                            if (typeof response.key == "undefined" &&
                                response.length > 1) {
                                response.forEach(function(key_obj) {
                                    key_array.push(key_obj.key);

                                });
                            } else {
                                key_array.push(response.key);
                            }
                            keys_length--;

                            // Force to close the memcache connection once all the keys are
                            // read.
                            if (keys_length == 0) {
                                self.memcached.end(); // Kills Memcache Connection
                                console.log("MEMCACHE CONNECTION END");
                                console.log("\nMEMCACHE KEYS\n");
                                //console.log(key_array);
                                callback(key_array)
                            }
                        });
                    
                });

            });
        });
    };

     // Flush All keys
    flushKeys() {
    	var self=this;
		this.readKeys(function(rows){
		//console.log(rows);
		  rows.forEach(function(row) {
		  	//console.log(row);
			self.memcached.del(row,function (err,result) { 
				if(err)console.log(err);

				console.log(result); 
			});
		  });
		});
    	
    }

//this.memcached.del('foo', function (err) { /* stuff */ });

/*memcached.set('profile', profile, 10000, function (err) { 
  if(err) throw new err;
});*/
}

module.exports = MemcachedLib;