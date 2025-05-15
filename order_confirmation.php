<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/logo.png">
    <title>Заказ подтвержден</title>
    <style>
        body {
            font-family: "Inter", sans-serif;
            background-color: #FCE3A5;
            margin: 0;
            padding: 0;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .confirmation-container {
            background-color: #FFF0CA;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 600px;
        }

        .confirmation-container h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .confirmation-container p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        .back-to-home-button {
            padding: 15px 30px;
            border-radius: 5px;
            border: none;
            background-color: #ebd294;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .back-to-home-button:hover {
            background-color: #dabf7a;
        }
    </style>
</head>

<body>
    <main>
        <div class="confirmation-container">
            <h1>Ваш заказ в обработке!</h1>
            <p>Спасибо за заказ. Мы свяжемся с вами в ближайшее время.</p>
            <a href="index.php">
                <button class="back-to-home-button">Вернуться на главную</button>
            </a>
        </div>
    </main>
</body>

</html>