const express = require('express');
const mongoose = require('mongoose');
const app = express();

const uri = "mongodb+srv://Dervaux:Dervaux@cluster0.hk19pvt.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0"

async function connect(){
    try {
        await mongoose.connect(uri)
        console.log("connected to mongoDB");
    }catch(error){
        console.error(error);
    }
}

connect();

app.listen(8000, ()=>{
    console.log("server started on port 8000");
});