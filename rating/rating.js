function validate(){  
    var username=document.form.city.value; 
    var eroare=document.getElementById('eroare'); 
    let text=document.createTextNode('');
    eroare.appendChild(text);
    if (username==null || username==""){  
        eroare.innerText='Introduceți numele orașului';
        eroare.style.display='block';  
        return false;
    }
}  