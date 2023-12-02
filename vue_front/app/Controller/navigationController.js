'use strict';

var NavigationModel = require('../Model/navigationModel.js');

exports.categoryList = function (req, res) {
    NavigationModel.fetch(function (err, result) {
        if (err)
            res.send(err);
        const categoriesList = processSubcategories(result).filter(Boolean);
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
    });

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
};