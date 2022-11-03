function validate(){  
    var username=document.form.username.value;  
    var cod=document.form.cod.value;
    var email=document.form.email.value; 
    var eroare=document.getElementById('eroareCod'); 
    let text=document.createTextNode('');
    eroare.appendChild(text);
    if (username==null || username==""){  
        eroare.innerText='Introduceți numele orașului';
        eroare.style.display='block';  
        return false; 
      }else if (cod==null || cod==""){  
        eroare.innerText='Introduceți id-ul'; 
        eroare.style.display='block';
      return false;  
    }
      if (email==null || email==""){  
        eroare.innerText='Introduceți adresa de email';
        eroare.style.display='block';  
        return false;  
      }
      
}  