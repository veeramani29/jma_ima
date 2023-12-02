// Setup express
const express = require('express');
const app = express();
const cors = require('cors');
const mysql = require('mysql');
app.use(cors());
const con = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "ima_laravel_test",
  /*waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0*/
});
// Setup express here...


// Setup social-login


// Init
// app.get('/linkedIn', (req, res, err) => {
//   const socialLoginClass = require("social-login");
//   console.log("working");
//   var socialLogin = new socialLoginClass({
//     returnRaw: true,
//     app: app,
//     url: 'http://localhost:5000',
//     onAuth: function (req, type, uniqueProperty, accessToken, refreshToken, profile, done) {
//       findOrCreate({
//           profile: profile,
//           property: uniqueProperty,
//           type: "linkedin"
//         },
//         function (user) {
//           done(null, user);
//         }
//       );
//     }
//   });
//   console.log(socialLogin);
//   // Setup the various services:
//   socialLogin.use({
//     linkedin: {
//       settings: {
//         clientID: "78kztb0v4r824h",
//         clientSecret: "5ahxppwruJ7Djjeg",
//         authParameters: {
//           scope: ['r_basicprofile', 'r_emailaddress', 'r_fullprofile', 'r_contactinfo', 'r_network', 'rw_nus']
//         }
//       },
//       url: {
//         auth: "http://laravel.indiamacroadvisors.com/user/",
//         callback: "http://laravel.indiamacroadvisors.com/user/linkedinProcess/",
//         success: 'https://vuejs.org/v2/guide/installation.html',
//         fail: 'http://google.com/'
//       }
//     },
//   });
//   res.send("nothing");
// });

app.get('/categories', (req, res, err) => {
  con.query('SELECT category_group,category_url,post_category_parent_id,post_category_id,post_category_name FROM post_category WHERE post_category_status = "Y" order by category_order asc', (err, rows, fields) => {
    if (!err) {
      const categoriesList = processSubcategories(rows).filter(Boolean);
      const categories = [{
          icon: "bar_chart",
          title: "DATA & EVENTS",
          indicators: []
        },
        {
          icon: "vpn_key",
          title: "IMA Premium",
          indicators: []
        }
      ];
      for (var i = 0; i < categoriesList.length; i++) {
        if (categoriesList[i].group == "DATA & EVENTS") {
          categories[0].indicators.push(categoriesList[i]);
        }
        if (categoriesList[i].group == "IMA PREMIUM") {
          categories[1].indicators.push(categoriesList[i]);
        }
      }
      res.send(categories);
    } else {
      console.log(err);
      res.send({
        err_code: "manual",
        message: "get error"
      });
    }
  })

  function processSubcategories(result, pid = 0, path = "") {
    var op = [];
    for (var i = 0; i < result.length; i++) {
      if (result[i].post_category_parent_id == pid) {
        op[result[i].post_category_id] = {
          'group': result[i].category_group,
          'id': result[i].post_category_id,
          'name': result[i].post_category_name,
          'url': "",
          'path': path + "/" + result[i].category_url,
          'children': []
        };
        var children = processSubcategories(result, result[i].post_category_id, path + "/" + result[i].category_url).filter(Boolean);
        if (children.length != 0) {
          op[result[i].post_category_id].children = children;
        } else {
          op[result[i].post_category_id].url = path + "/" + result[i].category_url;
        }
      }

    }
    return op;
  }
});

app.listen(5000, "localhost", () => {
  console.log(`Server running at http://localhost:5000/`);
});