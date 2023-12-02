//config file for globally declared variables
const config = require('./configuration');
app.use('/configuration', config);
const port = process.env.PORT || env('NODE_PORT');
const hostname = process.env.HOST || env('NODE_HOST') || '127.0.0.1';
const corsOptions = {
  origin: [`http://${hostname}:${port}`, `http://${hostname}:${env('APP_PORT')}`],
  methods: ['PATCH', 'PUT', 'DELETE'],
  credentials: true,
  //origin: true,
  enablePreflight: true //(xcsrf token)
}


//console.log(corsOptions);
//access control permission
app.use(cookieParser())
app.use(cors(corsOptions));
//app.options('*', cors(corsOptions)) // enable pre-flight request for DELETE request
app.use(express.urlencoded({
  extended: true
}));
app.use(bodyParser.json());
////app.use(express.static(__dirname + '/views'));
// middleware function to set sessions
app.use(session({
  key: 'admins_ima_id',
  secret: 'INDIAmacroADVISORS',
  saveUninitialized: true,
  resave: false,
  cookie: {
    secure: false,
    httpOnly: true,
    path: '/',
    maxAge: 24 * 60 * 60 * 1000
  }
}));

if (env('APP_ENV') === 'production') {
  // trust first proxy
  app.set('trust proxy', 1);
  // session.cookie.secure = true // serve secure cookies

}

// middleware function to set headers
app.use(function (req, res, next) {
  // Website you wish to allow to connect
  // res.setHeader('Access-Control-Allow-Origin', '*');
  if (env('APP_ENV') != 'development')
    res.setHeader('Access-Control-Allow-Origin', env('APP_URL'));
  //  'http://' + req.headers.origin
  // Request methods you wish to allow
  res.setHeader('Access-Control-Allow-Methods', 'GET, POST, HEAD');
  // Request headers you wish to allow
  res.setHeader('Access-Control-Allow-Headers', 'Origin,X-Requested-With,Content-Type, Authorization');
  // Set to true if you need the website to include cookies in the requests sent
  // to the API (e.g. in case you use sessions)
  res.setHeader('Access-Control-Allow-Credentials', 'true');
  res.setHeader('Access-Control-Expose-Headers', 'logged-in');


  // Pass to next layer of middleware
  next();
});



// middleware function to check for logged-in users
global.sessionChecker = (req, res, next) => {


  var token = req.headers['authorization'];


  if (req.path == '/api/v1/login/login' || req.path == '/api/v1/post/saveFile' || req.path == '/api/v1/login/sessionDestroy' || req.path == '/api/v1/badrequest' || req.path == '/api/v1/sessions') return next();

  if (req.session.Users && Object.keys(req.session.Users).length) {
    res.setHeader('logged-in', true);
    console.log(req.session.Users);
    jwt.verify(token, 'INDIAmacroADVISORS-secret', function (err, decoded) {
      if (err) return res.status(500).send({
        auth: false,
        message: 'Failed to authenticate token.'
      });
      // res.status(200).send(decoded);
    });
    if (!token) return res.status(401).send({
      auth: false,
      message: 'No token provided.'
    });
    return next();
  } else {
    //return res.redirect('http://localhost:8080/');
    return res.redirect('/api/v1/badrequest');
  }


};

//Login related queries
router.use('/login', require('./modules/login'));

//post related queries
router.use('/post', require('./modules/post'));

//Archive related queries
router.use('/archive', require('./modules/archive'));

//category related queries
router.use('/category', require('./modules/category'));

//media related queries
router.use('/media', require('./modules/media'));

//media related queries
router.use('/material', require('./modules/material'));

//Graph related queries
router.use('/graph', require('./modules/graph'));

//mapGraph related queries
router.use('/map', require('./modules/map'));

//user related queries
router.use('/user', require('./modules/user'));

//emailTemplates related queries
router.use('/emailTemplates', require('./modules/emailTemplates'));

//emailTemplates related queries
router.use('/company', require('./modules/company'));

//settings related queries
router.use('/settings', require('./modules/settings'));

router.get('/badrequest', (req, res) => {
  return res.status(400).send({
    message: '400 Bad Requeste\n'
  })
  // res.sendFile(__dirname + '/public/badrequest.html');
});
router.get('/sessions', (req, res) => {

  if (!req.session.Users) {
    req.session.Users = {}
  }
  return res.status(200).send(req.session.Users)

});
app.all('*', sessionChecker);
//The  Route Prefix (ALWAYS Keep this as the last route)
app.use('/api/v1', router);






//The 404 Route (ALWAYS Keep this as the last route)
app.use(function (req, res, next) {
  //console.error(err);
  return res.status(404).send({
    message: 'Route ' + req.url + ' Not found.'
  })
});

app.use(function (err, req, res, next) {
  //console.error(err.stack)
  return res.status(500).send({
    message: '500 Something broke!',
    error: JSON.parse(err)
  })
});



app.listen(port, hostname, () => {
  console.log(`Server running at http://${hostname}:${port}/`);
});