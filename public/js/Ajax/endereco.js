 function showHint(str) {
    if (str.length == 0) { 
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                $("#txtHint").append(this.responseText);
                document.getElementById('txtHint').disabled = false;
            }
        };
        xmlhttp.open("GET", "/medicos/te?dados=" + str, true);
        xmlhttp.send();
    }
}

function showResult(str) {
    if (str.length==0) { 
     
    }
    if (window.XMLHttpRequest) {
   
      xmlhttp=new XMLHttpRequest();
    } else {  
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("livesearch").innerHTML = this.responseText;
        document.getElementById("livesearch").style.border="1px solid #A5ACB2";
      }
    }
    xmlhttp.open("GET","/te?q="+str,true);
    xmlhttp.send();
  }