const openBtn = document.getElementById("openButton");
const closeBtn = document.getElementById("closeButton");
const modal = document.getElementById("promotion");
const time = Math.floor(Math.random() * (20000 - 10000 + 1)) + 10000;


//openBtn.addEventListener("click", ()=> {
 //   modal.classList.add("open"); });

closeBtn.addEventListener("click",()=>{

modal.classList.remove("open");

})


const myTimeout = setTimeout(popUpOpener, 5000);


function popUpOpener(){
modal.classList.add("open");
clearTimeout(myTimeout);

}




