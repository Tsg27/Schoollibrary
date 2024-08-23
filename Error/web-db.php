<!DOCTYPE html>
<html lang="Pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro de Conexão</title>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }
        .error-container {
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 32px;
        }
        .error-title {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }
        .error-details {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            margin-top: 20px;
        }
        .error-message {
            font-size: 20px;
            color: #333;
            
        }
    </style>
</head>
<body>
    <div class="error-container">
        <p class="error-message">Erro ao estabelecer uma conexão com banco de dados.</p>
        <hr>
        <?php if (isset($_GET['error'])): ?>
            <div class="error-details">
                <strong>Detalhes:</strong>
                <pre><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></pre>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>