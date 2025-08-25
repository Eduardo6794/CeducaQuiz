let btn_enviar = document.getElementById('btn_enviar');
let btn_enviar_actived = document.getElementById('btn_enviar_actived');


function btn_enviar() {

    preventDefault();

    if (btn_enviar.style.display == 'flex') {

        btn_enviar.style.display = 'none';
        btn_enviar_actived.style.display = 'flex';

    } else {
        btn_enviar.style.display = 'flex';
        btn_enviar_actived.style.display = 'none';
    }

    setInterval (btn_enviar, 200);

    

}