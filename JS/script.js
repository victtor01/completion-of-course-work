function clicar_categoria(){
  let fundo1 = document.getElementById("fundo-registrar-categoria");
  let registro = document.getElementById("registrar-categoria");
  

  fundo1.style.display = "flex";
  registro.style.display ="block";

}
function clicar_fornecedor() {
  let fundo = document.getElementById("fundo-registrar-fornecedor");
  let registro = document.getElementById("registrar-fornecedor");
  fundo.style.display = "flex";
  registro.style.display = "block";
}


var hidden = true;
function ClientesFuncionarios(){
  var clientesfuncionarios = window.document.querySelector('#href-clientes-funcionarios');
  var imagem_seta = window.document.getElementById('ion-icon-seta');

  if(hidden == true){
    clientesfuncionarios.style.cssText =
    'display: block;';

    hidden = false;
    imagem_seta.style.cssText = 
    'transform: rotate(90deg)';
  }
  else{ 
    clientesfuncionarios.style.display = "none";
    hidden = true;
    imagem_seta.style.cssText = 
    'transform: rotate(0deg)';
  }
}

var hiddenFinanceiro = true;
function Financeiro(){
  var funcionarios = window.document.getElementById('href-financeiro');
  let imagem_seta = window.document.getElementById('ion-icon-seta-financeiro');

  if(hiddenFinanceiro == true){
    funcionarios.style.display = "block";
    hiddenFinanceiro = false;
    imagem_seta.style.cssText = 
    'transform: rotate(90deg)';
  }
  else{ 
    funcionarios.style.display = "none";
    hiddenFinanceiro = true;
    imagem_seta.style.cssText = 
    'transform: rotate(0deg)';
  }
}

function LucroPorcentagem(){
  let valor_unidade = window.document.getElementById('valor_unidade').value;
  let preco_venda = window.document.getElementById('preco_venda').value;

  var valor = parseFloat(valor_unidade);
  var preco = parseFloat(preco_venda);
  console.log(valor);

  
  let diferenca = (preco - valor);
  let porcentagem = (diferenca / valor);
  let subtotal = (porcentagem * 100);

  var total = parseFloat(subtotal);
  total = round(total);

  let lucro = window.document.getElementById('lucro');
  lucro.value = total;
}

function round(num) {
  var m = Number((Math.abs(num) * 100).toPrecision(15));
  return Math.round(m) / 100 * Math.sign(num);
}