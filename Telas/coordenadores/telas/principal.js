function retorna() {
    location.href = "../index.php";
}

function redireciona_config() {
    location.href = "config_coord.php";
}

function alunos() {
    let div_alunos = document.getElementById("alunos");
    let div_prof = document.getElementById("professores");

    div_alunos.style.display = 'flex';
    div_prof.style.display = 'none';
    document.getElementById('chart_div').innerHTML = '';
}

function professores() {
    let div_alunos = document.getElementById("alunos");
    let div_prof = document.getElementById("professores");

    div_alunos.style.display = 'none';
    div_prof.style.display = 'flex';
    document.getElementById('chart_div_prof').innerHTML = '';
}



google.charts.load('current', {packages: ['corechart']});
google.charts.setOnLoadCallback(setupTurmas);

function setupTurmas() {
    // Listener para alunos
    document.getElementById("ID_Turma2").addEventListener("change", turmas2);
    // Listener para professores
    document.getElementById("ID_Turma").addEventListener("change", turmas);
}

function turmas() {
    const ID_Turma = document.getElementById("ID_Turma");
    const valor_ID_Turma = ID_Turma.value;

    if (!valor_ID_Turma) {
        document.getElementById('chart_div').innerHTML = '';
        return;
    }

    fetch('grafico_alunos.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ID_Turma: valor_ID_Turma })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        desenhaGrafico(data);
    });
}

function turmas2() {
    const ID_Turma = document.getElementById("ID_Turma2");
    const valor_ID_Turma = ID_Turma.value;

    if (!valor_ID_Turma) {
        document.getElementById('chart_div_prof').innerHTML = '';
        return;
    }

    fetch('grafico_professor.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ID_Turma: valor_ID_Turma })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        graficoprof(data);
    });
}

let ultimoData = null;
function desenhaGrafico(data) {
    ultimoData = data;
    var chartData = google.visualization.arrayToDataTable([
        ['Situação', 'Quantidade'],
        ['Ativos', data.ativos],
        ['Desistentes', data.desistentes],
        ['Retidos', data.retidos]
    ]);
    var options = {
        title: 'Situação dos Alunos',
        pieHole: 0.4,
        legend: { position: 'bottom' },
        chartArea: { width: '90%', height: '75%' }
    };
    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(chartData, options);
}

let ultimoData2 = null;
function graficoprof(data) {
    ultimoData2 = data;
    var chartData = google.visualization.arrayToDataTable([
        ['Situação', 'Quantidade'],
        ['Ativos', data.total],
    ]);
    var options = {
        title: 'Quantidade Professores',
        pieHole: 0.4,
        legend: { position: 'bottom' },
        chartArea: { width: '90%', height: '75%' }
    };
    var chart = new google.visualization.PieChart(document.getElementById('chart_div_prof'));
    chart.draw(chartData, options);
}

window.addEventListener('resize', function() {
    if (document.getElementById("alunos").style.display === 'flex' && ultimoData) {
        desenhaGrafico(ultimoData);
    }
    if (document.getElementById("professores").style.display === 'flex' && ultimoData2) {
        graficoprof(ultimoData2);
    }
});