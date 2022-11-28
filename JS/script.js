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

  let diferenca = (preco - valor);
  let porcentagem = (diferenca / valor);
  let subtotal = (porcentagem * 100);

  var total = parseFloat(subtotal);
  total = round(total);

  if(!total){
    total = 0;
  }

  let lucro = window.document.getElementById('lucro');
  lucro.value = total;

  if(total <= 0){
    let teste = window.document.getElementById('preco_venda');
    teste.style.cssText = 
    'color: red;' +
    'border: 2px solid red;';
  } else if(total < 20){
    let teste = window.document.getElementById('preco_venda');
    teste.style.cssText = 
    'color: blue';
  }
  else {
    let teste = window.document.getElementById('preco_venda');
    teste.style.cssText = 
    'color: green';
  }
}
function ValorVenda(e){
  let id = e.id;
  let lucro = window.document.getElementById(`${id}`);
  let valor_compra = window.document.getElementById('valor_unidade');
  let valor = (parseFloat(lucro.value)/100) * parseFloat(valor_compra.value);

  let total = parseFloat(valor_compra.value) + parseFloat(valor);
  total = parseFloat(total);

  if(!total){
    total = 0;
  }

  let valor_venda = window.document.querySelector('#preco_venda');
  valor_venda.value = total;

  if(lucro.value <= 0){
    lucro_venda.style.cssText = 
    'color: red;' +
    'border: 2px solid red;';

  } else if(lucro.value < 10){
    valor_venda.style.cssText = 
    'color: blue';
  }

  else {
    valor_venda.style.cssText = 
    'color: green';
  }
}

function round(num) {
  var m = Number((Math.abs(num) * 100).toPrecision(15));
  return Math.round(m) / 100 * Math.sign(num);
}