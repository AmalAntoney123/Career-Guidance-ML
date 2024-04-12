const express=require("express")
const app=express()
const path=require("path")
const hbs = require("hbs")

const tempelatePath = path.join(__dirname, '../tempelates')
app.listen(3000,()=>{
    console.log("port connected");
})