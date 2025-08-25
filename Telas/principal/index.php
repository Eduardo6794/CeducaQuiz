<?php 

    if ($_GET) {

        if ($_GET['cookiesAceitos'] == 'true') {
            setcookie('cookiesAceitos', 'true', time() + (86400 * 30), "/"); // 86400 = 1 dia
    
            if (isset($_COOKIE['cookiesAceitos'])) { 
                $teste = $_COOKIE['cookiesAceitos']; // Exibe o valor do cookie no console do navegador
                echo "<script>console.log('Cookies:$teste')</script>"; // Exibe os cookies armazenados no navegador
            }
    
        }

    }
    

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CeducaQuiz</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
</head>
<body>
    <nav id="navbar">
        <div id="imglogoRederecionamenteDesktop">
            <div id="containerImgLogo">
                <img src="../../asssets/logo.png" alt="" id="imglogo">
            </div>
            <div id="redirecionamentoDesktop">
                <ul>
                    <li><a href="#sobre">Sobre</a></li>
                    <li><a href="#documentacao">Documentação</a></li>
                    <li><a href="#contato">Contato</a></li>
                </ul>
            </div>
        </div>
        <div id="containerBtnEntrar" style="width: 150px;">
            <button id="btnEntrar">Entrar</button>
        </div>
        <div id="menuHamburguerMobile" onclick="showMenuMobile()">
            <div id="menuHumburguer1"></div>
            <div id="menuHumburguer2"></div>
            <div id="menuHumburguer3"></div>
        </div>
    </nav>
    <div id="menuMobile">
        <div id="redirecionamentoMobile">
            <ul>
                <li><a href="#sobre">Sobre</a></li>
                <li><a href="#documentacao">Documentação</a></li>
                <li><a href="#contato">Contato</a></li>
            </ul>
        </div>
        <div id="containerBtnEntrarMobile">
            <button id="btnEntrar" onclick="redirecionalogin()">Entrar</button>
        </div>
    </div>
    <main>
        <div id="containerBemVindo">
            <h1>Bem-Vindo ao Ceduca Quiz</h1>
        </div>
        <div class="containerIntroducao">
            <div class="containerTituloCeducaQuiz">
                <h1>Ceduca Quiz</h1>
            </div>
            <div id="conteudoImg">
                <div class="containerConteudoIntroducao">
                    <p>
                        O Ceduca Quiz é uma plataforma interativa de aprendizado que transforma o estudo em uma experiência divertida e dinâmica. Com quizzes personalizados, permite que alunos testem seus conhecimentos de forma lúdica, enquanto professores podem criar avaliações e monitorar o progresso em tempo real. Acessível em qualquer dispositivo, o Ceduca Quiz oferece uma maneira prática e eficiente de aprender e ensinar, promovendo um aprendizado mais envolvente e personalizado.
                    </p>
                    <br>
                    <div id="containerBtnEntrarMobile">
                        <button id="btnEntrar" onclick="redirecionalogin()" style="width: 100%;">Entrar</button>
                    </div>
                </div>
                <div id="containerImgsMobileIntroducao">
                    <div>
                        <img src="../../asssets/alunos1.jpg" alt="" id="imgMobileIntroducao">
                        <p id="pImgsIlustrativas">Imagens ilustrativas</p>
                    </div>
                    <div>
                        <img src="../../asssets/alunos2.jpg" alt="" id="imgMobileIntroducao">
                        <p id="pImgsIlustrativas">Imagens ilustrativas</p>
                    </div>
                    <div>
                        <img class="img-pc" src="../../asssets/alunosCropados.png" alt="" id="imgMobileIntroducaoDesktop">
                    </div>
                </div>
            </div>
            <div id="containerBarraQuebraPagina">
                <div id="barraQuebraPagina"></div>
            </div>
            <div class="containerIntroducao">
                <div class="containerTituloCeducaQuiz">
                    <h1 id="sobre">Sobre</h1>
                </div>
                <div class="containerConteudoIntroducao">
                    <p>
                        O Ceduca Quiz é uma plataforma educacional inovadora que utiliza quizzes para tornar o aprendizado mais interativo e engajador. Criado para alunos, professores e escolas, nosso objetivo é transformar a forma de estudar, proporcionando uma experiência divertida e personalizada.
                        Com quizzes adaptados ao nível de conhecimento de cada aluno, a plataforma oferece um ambiente de aprendizagem flexível e eficiente. Professores podem criar questões personalizadas, avaliar o desempenho dos alunos e acompanhar seu progresso em tempo real.
                        Acessível em diversos dispositivos, o Ceduca Quiz é a ferramenta ideal para quem busca aprimorar o aprendizado de forma prática, interativa e com resultados visíveis.
                    </p>
                </div>
            </div>
            <div id="containerBarraQuebraPagina">
                <div id="barraQuebraPagina"></div>
            </div>
            <div id="containerIntroducao">
                <div class="containerTituloCeducaQuiz">
                    <h1 id="documentacao">Documentação</h1>
                </div>
                <div class="containerConteudoIntroducao">
                    <p>
                        Faça o Download da Documentação do Ceduca Quiz no botão abaixo
                    </p>
                    <div id="containerBtnEntrarMobile">
                        <a href="../../Documentacao/documentacao.pdf" download="Documentação_CeducaQuiz"><button id="btnDownloadDoc">DownLoad</button></a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div id="seta">
        <a href="#navbar"><img src="../../icons/arrow_right.png" alt="" style="transform: rotate(270deg)"></a>
    </div>
    <footer>
        <div id="containerContatos">
            <div class="containersociais">
                <div id="linkedin">
                    <ul id="contato">
                        <li>
                            <img src="../../asssets/linkedinIcon.png" alt="" class="footerIcons">
                            <a href="https://www.linkedin.com/in/pedro-ernesto-2781b2309/" class="linkFormatado"><p>Pedro Ernesto</p></a>
                        </li>
                        <li>
                            <img src="../../asssets/linkedinIcon.png" alt="" class="footerIcons">
                            <a href="https://www.linkedin.com/in/pedro-ernesto-2781b2309/" class="linkFormatado"><p>Eduardo Couto</p></a>
                        </li>
                        <li>
                            <img src="../../asssets/linkedinIcon.png" alt="" class="footerIcons">
                            <a href="https://www.linkedin.com/in/pedro-ernesto-2781b2309/" class="linkFormatado"><p>Izac</p></a>
                        </li>
                    </ul>
                </div>
                <div id="github">
                    <ul>
                        <li>
                            <img src="../../asssets/githubIcon.png" alt="" class="footerIcons">
                            <a href="https://www.linkedin.com/in/pedro-ernesto-2781b2309/" class="linkFormatado"><p>Pedro Ernesto</p></a>
                        </li>
                        <li>
                            <img src="../../asssets/githubIcon.png" alt="" class="footerIcons">
                            <a href="https://www.linkedin.com/in/pedro-ernesto-2781b2309/" class="linkFormatado"><p>Eduardo Couto</p></a>
                        </li>
                        <li>
                            <img src="../../asssets/githubIcon.png" alt="" class="footerIcons">
                            <a href="https://www.linkedin.com/in/pedro-ernesto-2781b2309/" class="linkFormatado"><p>Izac</p></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="links-footer">
                <a href="../../Documentacao/politica_priv.php">Politica de Privacidade</a>
                <a href="../../Documentacao/politica_uso.php">Politica de Uso</a>
            </div>
        </div>
    </footer>
    <div id="cookies">
        <div>
            <span>Utilizamos cookies para melhorar a sua experiência em nosso site, personalizar conteúdo e anúncios, fornecer recursos de mídia social e analisar nosso tráfego. Ao continuar a navegar, você concorda com o uso de cookies. Para mais informações, consulte nossa <a>Política de Privacidade</a>.</span>
        </div>
        <div style="width: 100%; display: flex; flex-direction: row; justify-content: end; align-items: center; gap: 20px; padding:5px;">
            <button class="aceita_cookie" onclick="envia_cookie()" style="width: 80px;">Aceitar</button>
            <button class="recusa_cookie" onclick="recusar_cookie()" style="width: 80px;">Recusar</button>
        </div>
    </div>
    <script src="index.js"></script>
    <script>
        let div_cookie = document.getElementById('cookies');

        function recusar_cookie() {
            div_cookie.style.display = 'none';
        }

        function envia_cookie() {
            div_cookie.style.display = 'none'; 
            localStorage.setItem('cookiesAceitos', 'true');

            if (localStorage.getItem('cookiesAceitos') === 'true') {
                alert('Cookies aceitos com sucesso!');
                window.location.href = "index.php?cookiesAceitos=true";
            }
        }

        if (localStorage.getItem('cookiesAceitos') === 'true') {
            div_cookie.style.display = 'none';
        } else {
            div_cookie.style.display = 'flex';
        }
        
    </script>
</body>
</html>