<?php
require __DIR__ . '/../databases/database.php';

header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Проверка входных данных
    if (empty($input['task_id']) || empty($input['code'])) {
        throw new Exception('Неверные входные данные');
    }

    // Получаем задание из БД
    $stmt = $pdo->prepare("SELECT solution FROM tasks WHERE id = ?");
    $stmt->execute([$input['task_id']]);
    $task = $stmt->fetch();

    if (!$task) {
        throw new Exception('Задание не найдено');
    }

    // Простая проверка (можно расширить)
    $userCode = trim(preg_replace('/\s+/', '', $input['code']));
    $solution = trim(preg_replace('/\s+/', '', $task['solution']));
    
    $isCorrect = $userCode === $solution;

    echo json_encode([
        'success' => $isCorrect,
        'message' => $isCorrect 
            ? '✅ Решение верное! Молодец!' 
            : '❌ Решение содержит ошибки. Попробуйте еще раз.'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}