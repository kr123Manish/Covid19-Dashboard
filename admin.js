 const search = ()=> {
    // alert("H")
    let filter = document.getElementById('my-input').value.toUpperCase();
    // alert(filter);

    let ul = document.getElementById('ul');
    // console.log(ul);

    let val = ul.getElementsByTagName('li');
    // console.log(val);
    for(var i=0;i<val.length;i++){
        console.log(val[i]);
        let temp = val[i].getElementsByClassName("name")[0];
        
        if(temp){
            let textvalue = temp.textContent || temp.innerHTML;
            console.log(textvalue);
            if(textvalue.toUpperCase().indexOf(filter)>-1){
                val[i].style.display="";
            }else{
                val[i].style.display="none";
            }
        }


    }
}
