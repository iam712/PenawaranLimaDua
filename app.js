const express = require('express');
const session = require('express-session');
const bodyParser = require('body-parser');
const path = require('path');
const authController = require('./app/controllers/authController');  // Include the auth controller

const app = express();
const PORT = 3000;

// Middleware setup
app.use(bodyParser.urlencoded({ extended: false }));  // Parse incoming form data
app.use(session({
    secret: 'yourSecretKey',
    resave: false,
    saveUninitialized: true,
    cookie: { secure: false }
}));

// Serve static files (CSS, JS)
app.use(express.static(path.join(__dirname, 'assets')));

// Route to handle root URL "/"
app.get('/', (req, res) => {
    // Redirect to dashboard if user is logged in, otherwise to signin
    if (req.session.user) {
        res.redirect('/dashboard');
    } else {
        res.redirect('/signin');
    }
});

// Route to serve signin page
app.get('/signin', (req, res) => {
    if (req.session.user) {
        // If the user is already logged in, redirect to the dashboard
        res.redirect('/dashboard');
    } else {
        // If not logged in, show the sign-in page
        res.sendFile(path.join(__dirname, 'app/views/signin.html'));
    }
});

// Handle signin POST request (authentication)
app.post('/signin', authController.login);

// Route to serve dashboard (protected route)
app.get('/dashboard', (req, res) => {
    if (req.session.user) {
        // If logged in, show the dashboard page
        res.sendFile(path.join(__dirname, 'app/views/dashboard.html'));
    } else {
        // If not logged in, redirect to signin
        res.redirect('/signin');
    }
});

// Logout functionality
app.post('/logout', (req, res) => {
    // Destroy the session and redirect to signin page
    req.session.destroy(() => {
        res.redirect('/signin');
    });
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
