document.addEventListener("DOMContentLoaded", () => {

    const usuarioLogado = localStorage.getItem("usuario_logado");
    if (!usuarioLogado) {
        window.location.href = "login.html";
        return;
    }

    const selectCategoria = document.getElementById("selectCategoria");
    const selectPagamento = document.getElementById("selectPagamento");
    const formAgendamento = document.getElementById("formAgendamento");

    const secaoFormulario = document.getElementById("secaoFormulario");
    const secaoConfirmacao = document.getElementById("secaoConfirmacao");
    const resumoAgendamento = document.getElementById("resumoAgendamento");

    const btnAvancar = document.getElementById("btnAvancar");
    const btnVoltar = document.getElementById("btnVoltar");

    const blocosCategorias = {
        cabelo: document.getElementById("blocoCabelo"),
        manicure: document.getElementById("blocoManicure"),
        barba: document.getElementById("blocoBarba"),
        sobrancelhas: document.getElementById("blocoSobrancelhas"),
        massagens: document.getElementById("blocoMassagen"),
        pacotes: document.getElementById("blocoPacotes")
    };

    const blocoCartao = document.getElementById("blocoCartao");
    const blocoPix = document.getElementById("blocoPix");

    selectCategoria.addEventListener("change", () => {
        const valorSelecionado = selectCategoria.value;

        Object.keys(blocosCategorias).forEach(chave => {
            if (blocosCategorias[chave]) {
                blocosCategorias[chave].style.display = "none";
                const selectInterno = blocosCategorias[chave].querySelector("select");
                if (selectInterno) selectInterno.removeAttribute("required");
            }
        });

        if (valorSelecionado && blocosCategorias[valorSelecionado]) {
            blocosCategorias[valorSelecionado].style.display = "block";
            const selectInterno = blocosCategorias[valorSelecionado].querySelector("select");
            if (selectInterno) selectInterno.setAttribute("required", "required");
        }
    });

    selectPagamento.addEventListener("change", () => {
        const formaPagamento = selectPagamento.value;

        blocoCartao.style.display = "none";
        blocoPix.style.display = "none";
        
        document.getElementById("cartao").removeAttribute("required");
        document.getElementById("validade").removeAttribute("required");
        document.getElementById("cvv").removeAttribute("required");

        if (formaPagamento === "credito" || formaPagamento === "debito") {
            blocoCartao.style.display = "block";
            document.getElementById("cartao").setAttribute("required", "required");
            document.getElementById("validade").setAttribute("required", "required");
            document.getElementById("cvv").setAttribute("required", "required");
        } else if (formaPagamento === "pix") {
            blocoPix.style.display = "block";
        }
    });

    if (btnAvancar) {
        btnAvancar.addEventListener("click", () => {
            const dataHoraInput = document.getElementById("datahora");
            const profSelect = document.getElementById("selectProfissional");

            if (!dataHoraInput.value) {
                alert("Por favor, selecione a Data e Hora do Atendimento.");
                dataHoraInput.focus();
                return;
            }

            if (!selectCategoria.value) {
                alert("Por favor, selecione uma Categoria.");
                selectCategoria.focus();
                return;
            }

            if (!profSelect.value) {
                alert("Por favor, selecione um Profissional.");
                profSelect.focus();
                return;
            }

            if (!selectPagamento.value) {
                alert("Por favor, selecione o Método de Pagamento.");
                selectPagamento.focus();
                return;
            }

            const categoriaAtiva = selectCategoria.value;
            let procedimentoTexto = "Não especificado";
            
            if (categoriaAtiva && blocosCategorias[categoriaAtiva]) {
                const selectSub = blocosCategorias[categoriaAtiva].querySelector("select");
                if (selectSub && selectSub.selectedIndex > 0) {
                    procedimentoTexto = selectSub.options[selectSub.selectedIndex].text;
                } else {
                    alert("Por favor, escolha o procedimento específico da categoria.");
                    return;
                }
            }

            const profTexto = profSelect.options[profSelect.selectedIndex].text;
            const pagmetodo = selectPagamento.value.toUpperCase();

            let detalheCartao = "";
            if (selectPagamento.value === "credito" || selectPagamento.value === "debito") {
                const numCartao = document.getElementById("cartao").value;
                if (!numCartao) {
                    alert("Por favor, informe os dados do cartão.");
                    return;
                }
                const finalCartao = numCartao.slice(-4) || "****";
                detalheCartao = `<p><strong>Cartão final:</strong> **** **** **** ${finalCartao}</p>`;
            }

            resumoAgendamento.innerHTML = `
                <p><strong>Data/Hora:</strong> ${dataHoraInput.value.replace("T", " às ")}</p>
                <p><strong>Procedimento:</strong> ${procedimentoTexto}</p>
                <p><strong>Profissional:</strong> ${profTexto}</p>
                <p><strong>Forma de Pagamento:</strong> ${pagmetodo}</p>
                ${detalheCartao}
            `;

            secaoFormulario.style.display = "none";
            secaoConfirmacao.style.display = "block";
        });
    }

    if (btnVoltar) {
        btnVoltar.addEventListener("click", () => {
            secaoConfirmacao.style.display = "none";
            secaoFormulario.style.display = "block";
        });
    }

    formAgendamento.addEventListener("submit", async (e) => {
        e.preventDefault();

        const categoriaAtiva = selectCategoria.value;
        let especificacao = "";
        
        if (categoriaAtiva && blocosCategorias[categoriaAtiva]) {
            const selectSub = blocosCategorias[categoriaAtiva].querySelector("select");
            especificacao = selectSub ? selectSub.value : "";
        }

        const dadosAgendamento = {
            data_hora: document.getElementById("datahora").value,
            categoria: categoriaAtiva,
            especificacao: especificacao,
            profissional: document.getElementById("selectProfissional").value,
            metodo_pagamento: selectPagamento.value
        };

        try {
            const resposta = await fetch("agendar.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(dadosAgendamento)
            });

            const resultado = await resposta.json();

            if (resultado.status === "sucesso") {
                alert("Agendamento salvo com sucesso!");
                formAgendamento.reset();
                
                secaoConfirmacao.style.display = "none";
                secaoFormulario.style.display = "block";

                selectCategoria.dispatchEvent(new Event("change"));
                selectPagamento.dispatchEvent(new Event("change"));
            } else {
                alert("Erro no agendamento: " + resultado.mensagem);
            }
        } catch (erro) {
            console.error("Erro ao agendar:", erro);
            alert("Não foi possível conectar ao servidor. Por favor, verifique sua conexão.");
        }
    });
});