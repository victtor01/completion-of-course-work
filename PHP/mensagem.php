<?php

function mensagem($msg){
    switch($msg){
        case 1: 
        echo"<script>
                    let msg = window.document.getElementById('msg1');
                    msg.style.top = '10px';
                    var segundos = 0;
                    const tempo =  setInterval(() => {
                        if(segundos <=2){
                            segundos++;
                        }
                        else{
                            msg.style.top = '-100px';
                            clearInterval();
                        }
                    }, 1000);
            </script>";
        break;
        
        case 2: 
         echo"<script>
                let msg = window.document.getElementById('msg2');
                msg.style.top = '10px';
                var segundos = 0;
                const tempo =  setInterval(() => {
                    if(segundos <=2){
                        segundos++;
                    }
                    else{
                        msg.style.top = '-100px';
                        clearInterval();
                        window.location.replace('../HTML/produtos.php');
                    }
                }, 1000);
            </script>";
        break;
            
    }
}
