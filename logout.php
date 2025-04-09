<?php
session_start();
session_destroy(); // Уничтожение всех данных сессии

// Перенаправление на страницу входа
header("Location: login-form.php");
exit;
?>