//Linkedin Login
passport.use(
    new LinkedInStrategy({
            clientID: "78kztb0v4r824h",
            clientSecret: "5ahxppwruJ7Djjeg",
            callbackURL: "http://localhost:5000/auth/linkedin/callback",
            scope: ["r_emailaddress", "r_liteprofile"]
        },
        function (accessToken, refreshToken, profile, done) {
            process.nextTick(function () {
                return done(null, profile);
            });
        }
    )
);

app.get(
    "/linkedin",
    passport.authenticate("linkedin", {
        state: "SOME STATE"
    }),
    function (req, res) {}
);

app.get(
    "/auth/linkedin/callback",
    passport.authenticate("linkedin", {
        successRedirect: "http://localhost:8080/",
        failureRedirect: "http://localhost:8080/login"
    })
);
passport.serializeUser(function (user, done) {
    const userData = {
        fname: user.name.givenName,
        lname: user.name.familyName,
        email: user.emails[0].value,
        oauth_uid: user.id,
        linkedin_enabled: "Y"
    };
    sql.query(
        "SELECT * FROM " +
        user_table +
        ' WHERE oauth_uid="' +
        user.id +
        '" OR email="' +
        user.emails[0].value +
        '"',
        (err, rows) => {
            if (!err) {
                if (rows.length != 0)
                    sql.query(
                        "UPDATE " +
                        user_table +
                        " SET ? WHERE email ='" +
                        user.emails[0].value +
                        "'",
                        userData,
                        (err, rows, fields) => {
                            if (!err) {
                                console.log("Inserted successfully");
                            } else {
                                console.log(err);
                            }
                        }
                    );
                else
                    sql.query(
                        "INSERT INTO " + user_table + " SET ?",
                        userData,
                        (err, rows, fields) => {
                            if (!err) {
                                console.log("Inserted successfully");
                            } else {
                                console.log(err);
                            }
                        }
                    );
            } else {
                console.log(err);
            }
        }
    );
    return done(null, user);
});
passport.deserializeUser(function (user, done) {
    done(null, user);
});

//Facebook login
passport.use(
    new FacebookStrategy({
            clientID: "473493463560451",
            clientSecret: "26ce893e53bac3873d2b87596af10574",
            callbackURL: "http://localhost:5000/auth/facebook/callback",
            profileFields: ["id", "displayName", "photos", "email"]
        },
        function (accessToken, refreshToken, profile, done) {
            const userData = {
                fname: profile.displayName,
                lname: profile.displayName,
                email: profile.emails[0].value,
                facebook_oauth_id: profile.id,
                facebook_enabled: "Y"
            };
            sql.query(
                "SELECT * FROM " +
                user_table +
                ' WHERE oauth_uid="' +
                profile.id +
                '" OR email="' +
                profile.emails[0].value +
                '"',
                (err, rows) => {
                    if (!err) {
                        if (rows.length != 0)
                            sql.query(
                                "UPDATE " +
                                user_table +
                                " SET ? WHERE email ='" +
                                profile.emails[0].value +
                                "'",
                                userData,
                                (err, rows, fields) => {
                                    if (!err) {
                                        console.log("Inserted successfully");
                                    } else {
                                        console.log(err);
                                    }
                                }
                            );
                        else
                            sql.query(
                                "INSERT INTO " + user_table + " SET ?",
                                userData,
                                (err, rows, fields) => {
                                    if (!err) {
                                        console.log("Inserted successfully");
                                    } else {
                                        console.log(err);
                                    }
                                }
                            );
                    } else {
                        console.log(err);
                    }
                }
            );
            // const User = "";
            return done(null, profile);

        }
    )
);

app.get("/facebook", passport.authenticate("facebook", {
    scope: ["email"]
}));

app.get(
    "/auth/facebook/callback",
    passport.authenticate("facebook", {
        failureRedirect: "http://localhost:8080/login"
    }),
    function (req, res) {
        // Successful authentication, redirect home.
        res.redirect("http://localhost:8080/");
    }
);