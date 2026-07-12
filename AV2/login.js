document.addEventListener("DOMContentLoaded", () => {
    const secaoLogin = document.getElementById("secaoLogin");
    const secaoCadastro = document.getElementById("secaoCadastro");
    const linkParaCadastro = document.getElementById("linkParaCadastro");
    const linkParaLogin = document.getElementById("linkParaLogin");

    if (linkParaCadastro) {
        linkParaCadastro.addEventListener("click", (e) => {
            e.preventDefault();
            secaoLogin.style.display = "none";
            secaoCadastro.style.display = "block";
        });
    }

    if (linkParaLogin) {
        linkParaLogin.addEventListener("click", (e) => {
            e.preventDefault();
            secaoCadastro.style.display = "none";
            secaoLogin.style.display = "block";
        });
    }

    const formLogin = document.getElementById("formLogin");
    if (formLogin) {
        formLogin.addEventListener("submit", async (e) => {
            e.preventDefault();

            const dadosLogin = {
                email: document.getElementById("loginEmail").value,
                senha: document.getElementById("loginSenha").value
            };

            try {
                const resposta = await fetch("login.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(dadosLogin)
                });

                const resultado = await resposta.json();

                if (resultado.status === "sucesso") {
                    localStorage.setItem("usuario_logado", "true");
                    window.location.href = "index.html";
                } else {
                    alert(resultado.mensagem);
                }
            } catch (erro) {
                console.error("Erro ao autenticar:", erro);
                alert("Não foi possível conectar ao servidor.");
            }
        });
    }

    const formCadastro = document.getElementById("formCadastro");
    if (formCadastro) {
        formCadastro.addEventListener("submit", async (e) => {
            e.preventDefault();

            const dadosCadastro = {
                nome: document.getElementById("cadNome").value,
                email: document.getElementById("cadEmail").value,
                senha: document.getElementById("cadSenha").value
            };

            try {
                const respuesta = await fetch("cadastrar.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(dadosCadastro)
                });

                const resultado = await respuesta.json();

                if (resultado.status === "sucesso") {
                    alert("Usuário cadastrado com sucesso!");
                    formCadastro.reset();
                    secaoCadastro.style.display = "none";
                    secaoLogin.style.display = "block";
                } else {
                    alert("Erro no cadastro: " + resultado.mensagem);
                }
            } catch (erro) {
                console.error("Erro ao cadastrar:", erro);
                alert("Não foi possível conectar ao servidor.");
            }
        });
    }
});