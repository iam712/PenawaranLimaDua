// app/models/userModel.js

const bcrypt = require('bcrypt');

let users = [

    { username: 'user1', password: bcrypt.hashSync('password1', 10) },  // Pre-hash passwords
    { username: 'user2', password: bcrypt.hashSync('password2', 10) }

];

function findUserByUsername(username) {

    return users.find(user => user.username === username);
    
}

module.exports = { findUserByUsername };
