const express = require('express');
const mongoose = require('mongoose');
const bodyParser = require('body-parser');
const app = express();

const uri = "mongodb+srv://Dervaux:Dervaux@cluster0.hk19pvt.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0"

// Middleware pour parser le corps des requêtes en JSON
app.use(bodyParser.json());

async function connect(){
    try {
        await mongoose.connect(uri)
        console.log("connected to mongoDB");
    }catch(error){
        console.error(error);
    }
}

connect();

const logSchema = new mongoose.Schema({
    level: String,
    message: String,
    timestamp: {
        type: Date,
        default: Date.now
    }
});

app.listen(8000, ()=>{
    console.log("server started on port 8000");
});