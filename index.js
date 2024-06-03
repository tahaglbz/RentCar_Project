const closeBtn = document.getElementById("closeButton");
const modal = document.getElementById("promotion");
const time = Math.floor(Math.random() * (20000 - 10000 + 1)) + 10000;



closeBtn.addEventListener("click",()=>{

modal.classList.remove("open");

})


const myTimeout = setTimeout(popUpOpener,time);


function popUpOpener(){
modal.classList.add("open");
clearTimeout(myTimeout);

}