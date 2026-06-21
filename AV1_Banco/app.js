document.getElementById('formCadastro').addEventListener('submit', function(e) {
    e.preventDefault();

    const idEdicao = document.getElementById('idPerguntaEdicao').value;

    const dadosFormulario = {
        pergunta: document.getElementById('txtPergunta').value,
        tipo: document.getElementById('selectTipo').value,
        alt_a: document.getElementById('altA').value,
        alt_b: document.getElementById('altB').value,
        alt_c: document.getElementById('altC').value,
        alt_d: document.getElementById('altD').value
    };

    let urlDestino = idEdicao ? 'editar.php' : 'salvar.php';
    if (idEdicao) dadosFormulario.id = idEdicao;

    fetch('salvar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dadosFormulario)
    })
    .then(resposta => resposta.json())
    .then(resultado => {
        if (resultado.status === 'sucesso') {
            alert('Pergunta salva com sucesso.');
            document.getElementById('formCadastro').reset();
            carregarPerguntas();
        } else {
            alert('Erro ao salvar: ' + resultado.mensagem);
        }
    })
    .catch(erro => {
        console.error('Erro na requisição:', erro);
    });
});

function carregarPerguntas() {
    fetch('listar.php')
    .then(resposta => resposta.json())
    .then(perguntas => {
        const container = document.getElementById('listaPerguntas');
        container.innerHTML = '';

        perguntas.forEach(p => {
            const itemElemento = document.createElement('div');
            itemElemento.style.border = "1px solid #ccc";
            itemElemento.style.margin = "10px 0";
            itemElemento.style.padding = "10px";

            let conteudoHTML = `<strong>[${p.tipo.toUpperCase()}]</strong> ${p.texto_pergunta}<br>`;

            if (p.tipo === 'multipla_escolha') {
                conteudoHTML += `
                    <ul>
                        <li>A) ${p.alt_a || '---'}</li>
                        <li>B) ${p.alt_b || '---'}</li>
                        <li>C) ${p.alt_c || '---'}</li>
                        <li>D) ${p.alt_d || '---'}</li>
                    </ul>
                `;
            }

            
            conteudoHTML += `<br>
            <button onclick="prepararEdicao(${JSON.stringify(p).replace(/"/g, '&quot;')})">Editar</button>
            <button onclick="excluirPergunta(${p.id})">Excluir</button>`;

            itemElemento.innerHTML = conteudoHTML;
            container.appendChild(itemElemento);
        });
    })
    .catch(erro => console.error('Erro ao listar:', erro));
}

function excluirPergunta(idPergunta) {
    if (confirm("Tem certeza que deseja excluir esta pergunta?")) {
        
        fetch('excluir.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: idPergunta })
        })
        .then(resposta => resposta.json())
        .then(resultado => {
            if (resultado.status === 'sucesso') {
                alert('Pergunta excluída com sucesso.');
                carregarPerguntas();
            } else {
                alert('Erro ao excluir: ' + resultado.mensagem);
            }
        })
        .catch(erro => console.error('Erro na requisição:', erro));
    }
}

function Edicao(p) {
    document.getElementById('idPerguntaEdicao').value = p.id;
    document.getElementById('txtPergunta').value = p.texto_pergunta;
    document.getElementById('selectTipo').value = p.tipo;
    document.getElementById('selectTipo').dispatchEvent(new Event('change'));

    document.getElementById('altA').value = p.alt_a || '';
    document.getElementById('altB').value = p.alt_b || '';
    document.getElementById('altC').value = p.alt_c || '';
    document.getElementById('altD').value = p.alt_d || '';

    document.getElementById('Salvar').innerText = "Atualizar";
}

carregarPerguntas();