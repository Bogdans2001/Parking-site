function validate(){  
    var city=document.form.city.value;  
    var inm_number=document.form.inm_number.value;
    var card_number=document.form.card_number.value; 
    var zona=document.getElementById('zona'); 
    console.log(zona);
    var eroare=document.getElementById('eroare'); 
    let text=document.createTextNode('');
    eroare.appendChild(text);
    if (inm_number==null || inm_number==""){  
        eroare.innerText='Introduceți numărul de înmatriculare';
        eroare.style.display='block';  
        return false; 
      }else if (city==null || city==""){  
        eroare.innerText='Introduceți numele orașului'; 
        eroare.style.display='block';
      return false;  
    }else if(zona==null){
        eroare.innerText='Introduceți numărul zonei';
        eroare.style.display='block';  
        return false;  
      }else
      if (card_number==null || card_number==""){  
        eroare.innerText='Introduceți numărul cardului';
        eroare.style.display='block';  
        return false;  
      }
      
}  