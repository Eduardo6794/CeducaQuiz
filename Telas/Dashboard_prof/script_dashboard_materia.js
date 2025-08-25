
// JavaScript functions
function clickadd() {
    document.getElementById('Adicionar').style.display = 'flex';
    document.getElementById('Editar').style.display = 'none';
    document.getElementById('Excluir').style.display = 'none';
}

function clickedit() {
    document.getElementById('Adicionar').style.display = 'none';
    document.getElementById('Editar').style.display = 'flex';
    document.getElementById('Excluir').style.display = 'none';
}

function clickexclui() {
    document.getElementById('Adicionar').style.display = 'none';
    document.getElementById('Editar').style.display = 'none';
    document.getElementById('Excluir').style.display = 'flex';
}
