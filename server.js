const express = require ('express');
const bodyParser = require('body-parser');
const request = require('request');

const app = express();

app.use(bodyParser.urlencoded({extended: false}));
app.use(bodyParser.json());

//create route that will load our client html file
app.get('/', (req, res) => {
    res.sendFile(__dirname + '/html/sign-up.html'); //localhost should run the html file we selected
});

//Post request is made here
//we will submit the form using the 'fetch API'. To make request to the server
app.post('/html/sign-up.html', (req, res) => {
    //check if CAPTCHA is undefined, empty or NULL
    if (
        req.body.captcha === undefined ||
        req.body.captcha === '' ||
        req.body.captcha === null
    ) {
        return res.json({"success": false, "msg":"Please select captcha"});
    }
    //Secret Key
    const secretKey = '6Lf34sMpAAAAAJIVjs3zhUDROTz6py2TUePON9_7';

    //Verigy URL
    const verifyUrl = `https://google.com/recaptcha/api/siteverify?secret=${secretKey}&response=${req.body.captcha}&remoteip=${req.socket.remoteAddress}`;

    //Make request to VerifyUrl
    request(verifyUrl, (err, response, body) => {
        body = JSON.parse(body);

        //If not successful
        if (body.success !== undefined && !body.success) {
            return res.json({"success": false, "msg":"Faileld captcha verification"});
        }

        //If successful
        return res.json({"success": true, "msg":"Captcha passed"});

    });
});

app.listen(5500, () => {
    console.log('Server started on port 5500');
});
