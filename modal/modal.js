function abrirmodal(modal){
    if(modal == 'button-entrada'){ 
        var modal_ = window.document.getElementById("modal-entrada");
        modal_.showModal();
    }
    else{
        var modal_ = window.document.getElementById("modal-saida");
        modal_.showModal();
    }
}
function fecharmodal(modal){
    if(modal == 'button-entrada-fechar'){
        var modal_ = window.document.getElementById("modal-entrada");
        modal_.close();
    }
    else if(modal == 'modal-password'){
        var modal_ = window.document.getElementById('modal-password');
        modal_.close();
    }
    else if(modal == 'button-saida-fechar'){
        var modal_ = window.document.getElementById("modal-saida");
        modal_.close();
    }
}