google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);


function drawChart() {
    
  let data = google.visualization.arrayToDataTable([

    ['year', 'entrada', 'saída'],
    ['jan',  15,      12],
    ['fev',  24,      12],
    ['mar',  30,       27],
    ['abr',  45,      34],
    ['jun', 20,        20],
    [' jul', 20,       20 ]
    

  ]);
  let data2 = google.visualization.arrayToDataTable([
    ['Year', 'Sales', 'Expenses'],
    ['2013',  1000,      400],
    ['2014',  1170,      460],
    ['2015',  660,       1120],
    ['2016',  1030,      540]
  ]);

  let options = {
    title: 'Performace da empresa',
    curveType: 'function',
    legend: { position: 'bottom' }
  };
  let options2 = {
    title: 'Company Performance',
    hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
    vAxis: {minValue: 0}
  }

  let chart2 = new google.visualization.AreaChart(document.getElementById('chart_div'));
  chart2.draw(data2, options2);

  let chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
  chart.draw(data, options);
}

// estilo com JS 

function clicar() {
  let fundo = document.getElementById("fundo-registrar")
  let registro = document.getElementById("registrar-produto")

  fundo.style.display = "flex";
  registro.style.display ="block";

}

function fechar() {
var contar = 0;

let fundo = document.getElementById("fundo-registrar")
let registro = document.getElementById("registrar-produto")

fundo.style.display = "none";
registro.style.display ="none";

}

function clicar_categoria(){
  let fundo1 = document.getElementById("fundo-registrar-categoria");
  let registro = document.getElementById("registrar-categoria");
  

  fundo1.style.display = "flex";
  registro.style.display ="block";

}
function fechar_categoria() {
  let fundo = document.getElementById("fundo-registrar-categoria");
  let registro = document.getElementById("registrar-categoria");

  fundo.style.display = "none";
  registro.style.display ="none";
}

function clicar_fornecedor() {
  let fundo = document.getElementById("fundo-registrar-fornecedor");
  let registro = document.getElementById("registrar-fornecedor");
  fundo.style.display = "flex";
  registro.style.display = "block";
}

function formatarMoeda() {
  var elemento = window.document.getElementById('fornecedor');
  var valor = elemento.value;
  valor = valor + '';
  valor = parseInt(valor.replace(/[\D]+/g, ''));
  valor = valor + '';
  valor = valor.replace(/([0-9]{2})$/g, ",$1");

  if (valor.length > 6) {
      valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
  }

  elemento.value = valor;
  if(valor == 'NaN') elemento.value = '';
}
