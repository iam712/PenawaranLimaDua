// app/controllers/authController.js

const { findUserByUsername } = require('../models/userModel');
const bcrypt = require('bcrypt');

function login(req, res) {
    const { username, password } = req.body;
    const user = findUserByUsername(username);

    if (user && bcrypt.compareSync(password, user.password)) {
        // Save the user session
        req.session.user = user;
        res.redirect('/dashboard');
    } else {
        // res.render('signin', { error: 'Invalid username or password'});
        // Store error message in the session
        req.session.error = 'Invalid username or password';
        res.redirect('/signin'); // Redirect back to the sign-in page
    }
}

function logout(req, res) {
    req.session.destroy();  // Destroy session
    res.redirect('/signin');
}

module.exports = { login, logout };
