<?php

$servidor = 'localhost';
$usuario = 'root';
$senha = 'root';
$banco = 'bot_curso';
$conn = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$numero_telefone = $_GET['telefone'];
$msg = $_GET['msg'];
$usuario = $_GET['usuario'];

// Inicializa a variável $resposta
$resposta = "";

// Verificar se o telefone já está no banco de dados
$sql = "SELECT * FROM usuario WHERE telefone = '$numero_telefone'";
$query = mysqli_query($conn, $sql);
$total = mysqli_num_rows($query);

// Caso o número não esteja no banco, insere um novo registro e envia a mensagem de boas-vindas
if ($total == 0) {
    $sql = "INSERT INTO usuario (telefone, status) VALUES ('$numero_telefone', '1')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $resposta = "Olá, bem vindo à clínica MedCenter. Oferecemos serviços de medicina, exames de imagem e laboratoriais.\nEscolha o número da opção desejada:\n1 - Consultas\n2 - Exames\n3 - Orçamento\n4 - Horário de atendimento";
        echo $resposta;
    }
} else {
    // Caso o número já exista, vamos verificar a última interação (status) e responder com base na escolha
    $dados_usuario = mysqli_fetch_assoc($query);
    $status = $dados_usuario['status'];

    // Verificar se o status está marcado como 'encerrado'
    if ($status == "encerrado") {
        if ($msg != "") {
            $resposta = "Olá, bem vindo à clínica MedCenter. Oferecemos serviços de medicina, exames de imagem e laboratoriais.\nEscolha o número da opção desejada:\n1 - Consultas\n2 - Exames\n3 - Orçamento\n4 - Horário de atendimento";
            echo $resposta;

            // Reiniciar o status para 1
            $sql = "UPDATE usuario SET status = '1' WHERE telefone = '$numero_telefone'";
            mysqli_query($conn, $sql);
        }
    } else {
        // Menu principal de opções
        if ($status == "1") {
            if ($msg == "1") {
                // Consultas
                $resposta = "Escolha a especialidade desejada:\n1 - Cardiologista\n2 - Dermatologista\n3 - Pediatra\n4 - Voltar ao menu inicial";
                echo $resposta;
                $sql = "UPDATE usuario SET status = 'consultas' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } elseif ($msg == "2") {
                // Exames
                $resposta = "Escolha a opção desejada:\n1 - Valor dos exames\n2 - Resultado dos exames\n3 - Falar com atendente";
                echo $resposta;
                $sql = "UPDATE usuario SET status = 'exames' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } elseif ($msg == "3") {
                // Orçamento
                $resposta = "Escolha a opção de orçamento desejada:\n1 - Exames Clínicos\n2 - Exames Ocupacionais";
                echo $resposta;
                $sql = "UPDATE usuario SET status = 'orcamento' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } elseif ($msg == "4") {
                // Horário de atendimento
                $resposta = "Segunda a Sexta: 07:00 às 17:00\nSábado: 07:00 às 12:00";
                echo $resposta;
            } else {
                // Outra opção inválida
                $resposta = "Escolha uma opção válida:\n1 - Consultas\n2 - Exames\n3 - Orçamento\n4 - Horário de atendimento";
                echo $resposta;
            }
        } elseif ($status == "consultas") {
            // Se o usuário está no menu de consultas
            if ($msg == "1") {
                // Cardiologista
                $resposta = "Especialidade: Cardiologista\nValor da consulta: R$ 300,00\nHorário de atendimento: Segunda e Quarta, das 10h às 16h.\nDeseja marcar a consulta?\n1 - Sim\n2 - Voltar ao menu de especialidades";
                echo $resposta;
                $sql = "UPDATE usuario SET status = 'cardiologista' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } elseif ($msg == "2") {
                // Dermatologista
                $resposta = "Especialidade: Dermatologista\nValor da consulta: R$ 250,00\nHorário de atendimento: Terça e Quinta, das 9h às 15h.\nDeseja marcar a consulta?\n1 - Sim\n2 - Voltar ao menu de especialidades";
                echo $resposta;
                $sql = "UPDATE usuario SET status = 'dermatologista' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } elseif ($msg == "3") {
                // Pediatra
                $resposta = "Especialidade: Pediatra\nValor da consulta: R$ 200,00\nHorário de atendimento: Segunda a Sexta, das 8h às 12h.\nDeseja marcar a consulta?\n1 - Sim\n2 - Voltar ao menu de especialidades";
                echo $resposta;
                $sql = "UPDATE usuario SET status = 'pediatra' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } elseif ($msg == "4") {
                // Voltar ao menu inicial
                $resposta = "Escolha o número da opção desejada:\n1 - Consultas\n2 - Exames\n3 - Orçamento\n4 - Horário de atendimento";
                echo $resposta;
                $sql = "UPDATE usuario SET status = '1' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } else {
                // Outra resposta inválida
                $resposta = "Por favor, escolha uma das opções:\n1 - Cardiologista\n2 - Dermatologista\n3 - Pediatra\n4 - Voltar ao menu inicial";
                echo $resposta;
            }
        } elseif ($status == "exames") {
            if ($msg == "1") {
                // Valor dos exames
                $resposta = "Aqui está a lista de exames disponíveis:\n1 - Hemograma: R$ 100,00\n2 - Raio-X: R$ 150,00\n3 - Ultrassom: R$ 200,00\n4 - Voltar ao menu inicial";
                echo $resposta;
                $sql = "UPDATE usuario SET status = 'valor_exames' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } elseif ($msg == "2") {
                // Resultado dos exames
                $resposta = "Escolha o exame para ver o resultado:\n1 - Hemograma\n2 - Raio-X\n3 - Ultrassom\n4 - Voltar ao menu inicial";
                echo $resposta;
                $sql = "UPDATE usuario SET status = 'resultado_exames' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } elseif ($msg == "3") {
                // Falar com atendente
                $resposta = "Você será direcionado para um atendente. Aguarde.";
                echo $resposta;
                $sql = "UPDATE usuario SET status = 'encerrado' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } else {
                $resposta = "Escolha uma opção válida:\n1 - Valor dos exames\n2 - Resultado dos exames\n3 - Falar com atendente";
                echo $resposta;
            }
        } elseif ($status == "valor_exames") {
            if ($msg == "1") {
                $resposta = "Você escolheu Hemograma. O valor é R$ 100,00. Deseja agendar?\n1 - Sim\n2 - Voltar ao menu inicial";
                echo $resposta;
            } elseif ($msg == "2") {
                $resposta = "Você escolheu Raio-X. O valor é R$ 150,00. Deseja agendar?\n1 - Sim\n2 - Voltar ao menu inicial";
                echo $resposta;
            } elseif ($msg == "3") {
                $resposta = "Você escolheu Ultrassom. O valor é R$ 200,00. Deseja agendar?\n1 - Sim\n2 - Voltar ao menu inicial";
                echo $resposta;
            } elseif ($msg == "4") {
                // Voltar ao menu inicial
                $resposta = "Escolha o número da opção desejada:\n1 - Consultas\n2 - Exames\n3 - Orçamento\n4 - Horário de atendimento";
                echo $resposta;
                $sql = "UPDATE usuario SET status = '1' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } else {
                $resposta = "Escolha uma opção válida:\n1 - Hemograma\n2 - Raio-X\n3 - Ultrassom\n4 - Voltar ao menu inicial";
                echo $resposta;
            }
        } elseif ($status == "resultado_exames") {
            // Resultados dos exames (simulação)
            if ($msg == "1") {
                $resposta = "Veremos se o resultado do Hemograma está disponível. Por favor, envie seu CPF sem espaço entre os números para verificação e aguarde.";
                echo $resposta;
            } elseif ($msg == "2") {
                $resposta = "Veremos se o resultado do Raio-X está disponível. Por favor, envie seu CPF sem espaço entre os números para verificação e aguarde.";
                echo $resposta;
            } elseif ($msg == "3") {
                $resposta = "Veremos se o resultado do Ultrassom está disponível. Por favor, envie seu CPF sem espaço entre os números para verificação e aguarde.";
                echo $resposta;
            } elseif ($msg == "4") {
                // Voltar ao menu inicial
                $resposta = "Escolha o número da opção desejada:\n1 - Consultas\n2 - Exames\n3 - Orçamento\n4 - Horário de atendimento";
                echo $resposta;
                $sql = "UPDATE usuario SET status = '1' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } else {
                $resposta = "Estamos com o seu *CPF* em breve um atendente irá lhe atender para fornecer mais informações sobre seu exame, aguarde um instante.\n4 - Voltar ao menu inicial";
                echo $resposta;
            }
        } elseif ($status == "orcamento") {
            if ($msg == "1") {
                // Exames Clínicos
                $resposta = "Escolha o exame clínico desejado:\n1 - Hemograma\n2 - Glicemia\n3 - Colesterol\n4 - Voltar ao menu inicial";
                echo $resposta;
                $sql = "UPDATE usuario SET status = 'orcamento_clinico' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } elseif ($msg == "2") {
                // Exames Ocupacionais
                $resposta = "Escolha o exame ocupacional desejado:\n1 - Audiometria\n2 - Espirometria\n3 - Exame de sangue\n4 - Voltar ao menu inicial";
                echo $resposta;
                $sql = "UPDATE usuario SET status = 'orcamento_ocupacional' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } else {
                // Outra opção inválida
                $resposta = "Escolha uma opção válida:\n1 - Exames Clínicos\n2 - Exames Ocupacionais";
                echo $resposta;
            }
        } elseif ($status == "orcamento_clinico") {
            // Orçamento para exames clínicos
            if ($msg == "1") {
                $resposta = "O orçamento para Hemograma é R$ 100,00. Deseja prosseguir?\n1 - Sim\n2 - Voltar ao menu inicial";
                echo $resposta;
            } elseif ($msg == "2") {
                $resposta = "O orçamento para Glicemia é R$ 50,00. Deseja prosseguir?\n1 - Sim\n2 - Voltar ao menu inicial";
                echo $resposta;
            } elseif ($msg == "3") {
                $resposta = "O orçamento para Colesterol é R$ 80,00. Deseja prosseguir?\n1 - Sim\n2 - Voltar ao menu inicial";
                echo $resposta;
            } elseif ($msg == "4") {
                // Voltar ao menu inicial
                $resposta = "Escolha o número da opção desejada:\n1 - Consultas\n2 - Exames\n3 - Orçamento\n4 - Horário de atendimento";
                echo $resposta;
                $sql = "UPDATE usuario SET status = '1' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } else {
                $resposta = "Escolha uma opção válida:\n1 - Hemograma\n2 - Glicemia\n3 - Colesterol\n4 - Voltar ao menu inicial";
                echo $resposta;
            }
        } elseif ($status == "orcamento_ocupacional") {
            // Orçamento para exames ocupacionais
            if ($msg == "1") {
                $resposta = "O orçamento para Audiometria é R$ 150,00. Aguarde o atendente retornar a mensagem.\n2 - Voltar ao menu inicial";
                echo $resposta;
            } elseif ($msg == "2") {
                $resposta = "O orçamento para Espirometria é R$ 180,00. Aguarde o atendente retornar a mensagem.\n2 - Voltar ao menu inicial";
                echo $resposta;
            } elseif ($msg == "3") {
                $resposta = "O orçamento para Exame de sangue é R$ 100,00. Aguarde o atendente retornar a mensagem.\n2 - Voltar ao menu inicial";
                echo $resposta;
            } elseif ($msg == "4") {
                // Voltar ao menu inicial
                $resposta = "Escolha o número da opção desejada:\n1 - Consultas\n2 - Exames\n3 - Orçamento\n4 - Horário de atendimento";
                echo $resposta;
                $sql = "UPDATE usuario SET status = '1' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } else {
                $resposta = "Escolha uma opção válida:\n1 - Audiometria\n2 - Espirometria\n3 - Exame de sangue\n4 - Voltar ao menu inicial";
                echo $resposta;
            }
        } elseif ($status == "cardiologista" || $status == "dermatologista" || $status == "pediatra") {
            // Marcação de consultas
            if ($msg == "1") {
                $resposta = "Sua consulta será agendada, aguarde o retorno de um dos nossos atendentes! Agradecemos por escolher a nossa clínica.\nPara voltar ao menu inicial, digite qualquer outro número.";
                echo $resposta;
                $sql = "UPDATE usuario SET status = 'encerrado' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } elseif ($msg == "2") {
                // Voltar ao menu de especialidades
                $resposta = "Escolha a especialidade desejada:\n1 - Cardiologista\n2 - Dermatologista\n3 - Pediatra\n4 - Voltar ao menu inicial";
                echo $resposta;
                $sql = "UPDATE usuario SET status = 'consultas' WHERE telefone = '$numero_telefone'";
                mysqli_query($conn, $sql);
            } else {
                $resposta = "Escolha uma opção válida:\n1 - Sim\n2 - Voltar ao menu de especialidades";
                echo $resposta;
            }
        } else {
            // Se o status não corresponder a nenhum dos casos anteriores
            $resposta = "Escolha uma opção válida:\n1 - Consultas\n2 - Exames\n3 - Orçamento\n4 - Horário de atendimento";
            echo $resposta;
            $sql = "UPDATE usuario SET status = '1' WHERE telefone = '$numero_telefone'";
            mysqli_query($conn, $sql);
        }
    }
}

mysqli_close($conn);
?>
