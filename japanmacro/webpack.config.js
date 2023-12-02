
  //var webpack =require('webpack');




var config_css ={
    name: "Compine Js Css",
    entry: "./assets/entry.js",
  output: {
        path: __dirname +"/assets/builds",
        filename: "bundle.js"
    },
   externals: {
    
      "jquery": "jQuery",
  },
 /* resolve: {
    alias: {
        'jquery': require.resolve('jquery'),
    }
  },
 plugins: [
 //new Jma('//localhost/jma/japanmacroadvisors/','home','index','','http',objectParams)
   /* new webpack.ProvidePlugin({
      "window.jQuery": "jquery",
      "window.$": "jquery"
    })
  ],*/
    module: {
     
        loaders: [

             { test: /\.css$/, loader: "style-loader!css-loader" },
              { test: /\.(txt?g)$/i, loaders: [ 'raw-loader?limit=10000', 'img?minimize' ] },
              // URL loader is loding and then emits By Data Format
              /*{ test: /\.(ttf|eot|woff|woff2)(\?v=[0-9]\.[0-9]\.[0-9])?$/, loader: "url-loader?name=fonts/[name].[ext]" },
              {test: /\.(jpe?g|png|gif|svg)$/i, loader: "url-loader?name=images/[name].[ext]"},*/
               // URL loader is loding By Data Format

           // { test: /\.(jpe?g|png|gif|svg)$/i, loaders: [ 'file?hash=sha512&digest=hex&name=images/[name].[ext]',
              // 'image-webpack?bypassOnDebug&optimizationLevel=7&interlaced=false'] },
              { test: /\.js$/, exclude: /node_modules/, loader: "babel-loader" },
            {test: /\.(jpe?g|png|gif|svg)$/i, loader: "file-loader?name=./assets/images/[name].[ext]"},
             { test: /\.(eot|ttf)(\?v=[0-9]\.[0-9]\.[0-9])?$/, loader: "file-loader?name=./assets/fonts/[name].[ext]" },
            { test: /\.(ttf|woff|woff2)(\?v=[0-9]\.[0-9]\.[0-9])?$/, loader: "file-loader?name=./assets/plugins/font-awesome/fonts/[name].[ext]" },
           
           
           // To save and load 
          
        ]
    }
};



//module.exports = config_css;



var config_offer_pack={
    name: "Compine Js Css",
    entry: "./assets/entry_offer.js",
  output: {
        path: __dirname +"/assets/builds",
        filename: "offer_pack.js"
    },
 externals: {
    
      "jquery": "jQuery",
  },
   
    module: {

        loaders: [
                { test: /\.css$/, loader: "style-loader!css-loader" },
           
            {test: /\.(jpe?g|png|gif|svg)$/i, loader: "file-loader?name=../assets/images/[name].[ext]"},
             { test: /\.(eot|ttf)(\?v=[0-9]\.[0-9]\.[0-9])?$/, loader: "file-loader?name=../assets/fonts/[name].[ext]" },
            { test: /\.(ttf|woff|woff2)(\?v=[0-9]\.[0-9]\.[0-9])?$/, loader: "file-loader?name=../assets/plugins/font-awesome/fonts/[name].[ext]" },
           
           
           // To save and load 
          
        ]
    }
};

//module.exports = { a:config_css ,b:config_offer_pack };

module.exports = {
    entry: {
        bundle: "./assets/entry.js",
        offer_pack: "./assets/offer_pack.js"
    },
    output: {
        path: __dirname +"/assets/builds",
        filename: "[name].js"
        
    },
 externals: {
    
      "jquery": "jQuery",
  },
   
    module: {

        loaders: [
                { test: /\.css$/, loader: "style-loader!css-loader" },
           
            {test: /\.(jpe?g|png|gif|svg)$/i, loader: "file-loader?name=../assets/images/[name].[ext]"},
             { test: /\.(eot|ttf)(\?v=[0-9]\.[0-9]\.[0-9])?$/, loader: "file-loader?name=../assets/fonts/[name].[ext]" },
            { test: /\.(ttf|woff|woff2)(\?v=[0-9]\.[0-9]\.[0-9])?$/, loader: "file-loader?name=../assets/plugins/font-awesome/fonts/[name].[ext]" },
           
           
           // To save and load 
          
        ]
    }
};

