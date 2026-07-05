<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Agendamento</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

    <form id="formAgendamento">
        <h2>Marcar Atendimento</h2>
        
        <label>Data e Hora do Atendimento:</label><br>
        <input type="datetime-local" id="datahora" min="2026-06-22T08:00" required>

        <label>Categoria de Serviço:</label><br>
        <select id="selectCategoria" required>
            <option value="">Selecione uma categoria</option>
            <option value="cabelo">Cabelo</option>
            <option value="manicure">Manicure</option>
            <option value="barba">Barba</option>
            <option value="sobrancelhas">Sobrancelhas</option>
            <option value="massagens">Massagens</option>
            <option value="pacotes">Pacotes Especiais</option>
        </select><br><br>

        <div id="blocoCabelo" style="display: none;">
            <label>Procedimentos de Cabelo:</label><br>
            <select id="selectCabelo">
                <option value="">Escolha o procedimento.</option>
                <option value="corte_simples">Corte Simples Feminino - R$ 60,00</option>
                <option value="pintar_cabelo">Pintar Cabelo - R$ 45,00</option>
                <option value="progressiva_curto">Progressiva Curto - R$ 40,00</option>
                <option value="corte_disfarcado">Corte Máquina Disfarçado - R$ 30,00</option>
                <option value="corte_undercut">Corte Undercut - R$ 35,00</option>
            </select><br><br>
        </div>

        <div id="blocoManicure" style="display: none;">
            <label>Procedimentos de Manicure:</label><br>
            <select id="selectManicure">
                <option value="">Escolha o procedimento</option>
                <option value="unha_de_gel">Colocação de Unhas de Gel - R$ 80,00</option>
                <option value="banho_fibra">Banho de Fibra - R$ 40,00</option>
                <option value="manutenção_gel">Manutenção de Unhas de Gel - R$ 30,00</option>
            </select><br><br>
        </div>

        <div id="blocoBarba" style="display: none;">
            <label>Procedimentos de Barba:</label><br>
            <select id="selectBarba">
                <option value="">Escolha o procedimento</option>
                <option value="barba_simples">Barba Simples - R$ 20,00</option>
                <option value="barba_pigmentada">Barba Pigmentada - R$ 35,00</option>
            </select><br><br>
        </div>

        <div id="blocoSobrancelhas" style="display: none;">
            <label>Procedimentos de Sobrancelhas:</label><br>
            <select id="selectSobrancelhas">
                <option value="">Escolha o procedimento</option>
                <option value="sobrancelha_masculina">Sobrancelha Masculina - R$ 25,00</option>
                <option value="design_sobrancelha">Design de Sobrancelha - R$ 25,00</option>
            </select><br><br>
        </div>

        <div id="blocoMassagen" style="display: none;">
            <label>Procedimentos de Massagem:</label><br>
            <select id="selectMassagen">
                <option value="">Escolha o procedimento</option>
                <option value="massagem_marreta">Massagem com Marreta (1h) - R$ 70,00</option>
            </select><br><br>
        </div>

        <div id="blocoPacotes" style="display: none;">
            <label>Escolha o seu Pacote:</label><br>
            <select id="selectPacotes">
                <option value="">Selecione o pacote</option>
                <option value="dia_dos_pais">Especial Dia dos Pais - R$ 50,00</option>
                <option value="beleza_completa">Belaza Completa - R$ 75,00</option>
            </select><br><br>
        </div>

        <label>Profissional:</label><br>
        <select id="selectProfissional" required>
            <option value="">Selecione o profissional</option>
            <optgroup label="Seus Favoritos">
                <option value="pedro_barbeiro">Pedro (Barbeiro)</option>
                <option value="miriam_sobrancelha">Mirian (Designer de Sobrancelha)</option>
            </optgroup>
            <optgroup label="Todos os profissionais">
                <option value="josé_cabeleireiro">José (Cabeleireiro)</option>
                <option value="joao_manicure">João (Manicure)</option>
                <option value="maria_massagista">Maria (Massagista)</option>
            </optgroup>
        </select><br><br>

        <label>Método de Pagamento:</label><br>
        <select id="selectPagamento" required>
            <option value="">Escolha como pagar</option>
            <option value="pix">PIX</option>
            <option value="credito">Cartão de Crédito</option>
            <option value="debito">Cartão de Débito</option>
        </select><br><br>

        <div id="blocoCartao" style="display: none;">
                <h4>Informações do Cartão</h4>
                <label>Número do Cartão:</label><br>
                <input type="text" id="cartao" placeholder="0000 0000 0000 0000"><br><br>

                <label>Validade:</label>
                <input type="text" id="validade" placeholder="MM/AA" size="5">

                <label style="margin-left: 10px;">CVV:</label>
                <input type="text" id="cvv" placeholder="123" size="3"><br><br>
        </div>

        <div id="blocoPix" style="display: none;">
                <h4>Pagamento via PIX</h4>
                <p>Clique em confirmar para gerar o código Copia e Cola.</p>
        </div>

        <button type="submit">Confirmar Agendamento</button>
        
    </form>

    <script src="script.js"></script>
</body>
</html>