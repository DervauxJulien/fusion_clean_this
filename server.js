const express = require('express');
const mongoose = require('mongoose');
const bodyParser = require('body-parser');
const app = express();

app.use(express.json);

const uri = "mongodb+srv://Admin:Cleanthis123!@cleanthislog.wnplv6a.mongodb.net/?retryWrites=true&w=majority&appName=CleanthisLog"

// Middleware pour parser le corps des requêtes en JSON
app.use(bodyParser.json());


// const logSchema = new mongoose.Schema({
//     level: String,
//     message: String,
//     timestamp: {
//         type: Date,
//         default: Date.now
//     }
// });

app.get("/", (req, res) => {
    res.json({
        message: "Bienvenue eee"
    })
})

app.post('/api/logs', (req,res)=>{
    res.send("Data Received")
});

app.listen(3000, () => {
    console.log("server started on port 3000");
});

mongoose.connect("mongodb+srv://Admin:Cleanthis123!@cleanthislog.wnplv6a.mongodb.net/?retryWrites=true&w=majority&appName=CleanthisLog").then(() => {
    console.log("connected");
})
    .catch(() => {
        console.error("failed");
    })