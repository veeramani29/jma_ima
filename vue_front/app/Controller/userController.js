'use strict';

var UserModel = require('../Model/UserModel.js');

exports.countryList = function(req, res) {
  UserModel.fetch(req.params.qry, new UserModel(req.body), function(err, result) {
    if (err)
      res.send(err);
    res.json(result);
  });
};

exports.industryList = function(req, res) {
  UserModel.fetch(req.params.qry, new UserModel(req.body), function(err, result) {
    if (err)
      res.send(err);
    res.json(result);
  });
};

exports.positionList = function(req, res) {
 // window.console.log(req.params.qry);
 UserModel.fetch(req.params.qry, new UserModel(req.body), function(err, result) {
    if (err)
      res.send(err);
    res.json(result);
  });
};

exports.create_user = function(req, res) {
  var userSignup = req.body;
  //console.log(req.body);
  //handles null error 
  if(!userSignup.fname || !userSignup.email){
      res.status(400).send({ error:true, message: 'Please provide user details' });
  }
  else{
            //console.log(req.email);
            UserModel.getUserByEmail(req.body.email, function(err, result) {
                //console.log(req.body.email);
                if (err)
                  res.send(err);
                else{
                      if(result.length===0){
                          UserModel.createUser(userSignup, function(err, createRes) {
                              if (err)
                                res.send(err);
                              res.json(createRes);
                          });
                      }
                      else{
                        res.send('Email address already exists');
                      }
                }  
              
            });
  }
};

exports.user_login = function(req, res) {
  // window.console.log(req.params.qry);
  UserModel.loginSubmit(new UserModel(req.body), function(err, result) {
     if (err)
       res.send(err);
     res.json(result);
   });
 };
 
 exports.defaultAlerts = function(req, res) {
  UserModel.defaultEmailAlert(function(err, result) {
    if (err)
      res.send(err);
    res.json(result);
  });
};

exports.getLastRegUser = function(req, res) {
  //console.log(req.params.qry);
  UserModel.getUserData(req.params.qry, new UserModel(req.params.qry),function(err, result) {
    if (err)
      res.send(err);
    res.json(result);
  });
};