document.addEventListener("DOMContentLoaded", function(){
//Buttons IDs
const bioButton = document.getElementById("bio-btn");
const eduButton = document.getElementById("edu-btn");
const workButton = document.getElementById("work-btn");

//Display screen IDs
const bioScreen = document.getElementById("biodata-screen");
const eduScreen = document.getElementById("education-screen");
const workScreen = document.getElementById("work-screen");

bioButton.addEventListener("click", (e)=>{
    e.target.style.background = "#ffffff50";
    eduButton.style.background = "none";
    workButton.style.background = "none";
    bioScreen.style.display = "block";
    eduScreen.style.display = "none";
    workScreen.style.display = "none";
});
eduButton.addEventListener("click", (e)=>{
    e.target.style.background = "#ffffff50";
    bioButton.style.background = "none";
    workButton.style.background = "none";
    bioScreen.style.display = "none";
    eduScreen.style.display = "block";
    workScreen.style.display = "none";
});
workButton.addEventListener("click", (e)=>{
    e.target.style.background = "#ffffff50";
    bioButton.style.background = "none";
    eduButton.style.background = "none";
    bioScreen.style.display = "none";
    eduScreen.style.display = "none";
    workScreen.style.display = "block";
});

//Education button IDs
const primaryButton = document.getElementById("pri-btn");
const secondaryButton = document.getElementById("sec-btn");
const higherButton = document.getElementById("higher-btn");
const nyscButton = document.getElementById("nysc-btn");

//Education screen IDs
const primaryScreen = document.getElementById("primary");
const secondaryScreen = document.getElementById("secondary");
const higherScreen = document.getElementById("higher");
const nyscScreen = document.getElementById("nysc");

primaryButton.addEventListener("click", (e)=>{
    e.target.style.color = "black";
    e.target.style.borderStyle = "solid";
    secondaryButton.style.borderStyle = "none";
    higherButton.style.borderStyle = "none";
    nyscButton.style.borderStyle = "none";
    secondaryButton.style.color = "blue";
    higherButton.style.color = "blue";
    nyscButton.style.color = "blue";
    primaryScreen.style.display = "block";
    secondaryScreen.style.display = "none";
    higherScreen.style.display = "none";
    nyscScreen.style.display = "none";
})
secondaryButton.addEventListener("click", (e)=>{
    e.target.style.color = "black";
    e.target.style.borderStyle = "solid";
    primaryButton.style.borderStyle = "none";
    higherButton.style.borderStyle = "none";
    nyscButton.style.borderStyle = "none";
    primaryButton.style.color = "blue";
    higherButton.style.color = "blue";
    nyscButton.style.color = "blue";
    primaryScreen.style.display = "none";
    secondaryScreen.style.display = "block";
    higherScreen.style.display = "none";
    nyscScreen.style.display = "none";
})
higherButton.addEventListener("click", (e)=>{
    e.target.style.color = "black";
    e.target.style.borderStyle = "solid";
    secondaryButton.style.borderStyle = "none";
    primaryButton.style.borderStyle = "none";
    nyscButton.style.borderStyle = "none";
    primaryButton.style.color = "blue";
    secondaryButton.style.color = "blue";
    nyscButton.style.color = "blue";
    primaryScreen.style.display = "none";
    secondaryScreen.style.display = "none";
    higherScreen.style.display = "block";
    nyscScreen.style.display = "none";
})
nyscButton.addEventListener("click", (e)=>{
    e.target.style.color = "black";
    e.target.style.borderStyle = "solid";
    secondaryButton.style.borderStyle = "none";
    higherButton.style.borderStyle = "none";
    primaryButton.style.borderStyle = "none";
    primaryButton.style.color = "blue";
    higherButton.style.color = "blue";
    secondaryButton.style.color = "blue";
    primaryScreen.style.display = "none";
    secondaryScreen.style.display = "none";
    higherScreen.style.display = "none";
    nyscScreen.style.display = "block";
})

})
