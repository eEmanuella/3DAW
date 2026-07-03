document.addEventListener("DOMContentLoaded", () => {
    const selectCategoria = document.getElementById("selectCategoria");
    const selectPagamento = document.getElementById("selectPagamento");
    const formAgendamento = document.getElementById("formAgendamento");

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

    formAgendamento.addEventListener("submit", async (e) => {
        e.preventDefault();

        const categoriaAtiva = selectCategoria.value;
        let especificacao = "";
        
        if (categoriaAtiva) {
            const divAtiva = blocosCategorias[categoriaAtiva];
            if (divAtiva) {
                const selectSub = divAtiva.querySelector("select");
                especificacao = selectSub ? selectSub.value : "";
            }
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
                selectCategoria.dispatchEvent(new Event("change"));
                selectPagamento.dispatchEvent(new Event("change"));
            } else {
                alert("Erro no agendamento: " + resultado.mensagem);
            }
        } catch (erro) {
            console.error("Erro ao agendar:", erro);
            alert("Não foi possível conectar ao servidor. Por favor, verifique sua conexão e tente novamente mais tarde.");
        }
    });
});