const username=document.getElementById("username");
const element = document.getElementById("links");
const active = document.getElementById("deconectare");
const signout=document.getElementById("stergere");
username.addEventListener("click",e=>{
e.preventDefault();
if(element.style.display=="none" || element.style.display==""){
element.style.display="block";
}
else
element.style.display="none";
})
active.addEventListener("click",e=>{
    e.preventDefault();
    if(confirm("Vreți să vă deconectați?")) window.location="../register/logout.php";
})
signout.addEventListener("click",e=>{
    e.preventDefault();
    if(confirm("Vreți să ștergeți contul?")) window.location="../register/signout.php";
})