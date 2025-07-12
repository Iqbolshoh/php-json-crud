<?php

header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && isset($data['name']) && isset($data['age'])) {

    if (empty($data['id']) || empty($data['name']) || empty($data['age'])) {
        echo json_encode([
            'success' => false,
            'message' => 'ID, Ism va Yosh maydonlari to\'ldirilishi shart.'
        ]);
        exit;
    }

    $id = $data['id'];
    $name = $data['name'];
    $age = $data['age'];

    if (!is_numeric($id)) {
        echo json_encode([
            'success' => false,
            'message' => 'ID raqam bo\'lishi kerak.'
        ]);
        exit;
    }

    if (!is_string($name)) {
        echo json_encode([
            'success' => false,
            'message' => 'Ism matn bo\'lishi kerak.'
        ]);
        exit;
    }

    if (is_numeric($age)) {
        if ($age < 0 || $age > 120) {
            echo json_encode([
                'success' => false,
                'message' => 'Yosh 0 dan 120 gacha bo\'lishi kerak.'
            ]);
            exit;
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Yosh raqam bo\'lishi kerak.'
        ]);
        exit;
    }

    $allUsers = [];
    if (file_exists('users.json') && filesize('users.json') > 0) {
        $allUsers = json_decode(file_get_contents('users.json'), true);
    }

    $allUsers[] = [
        'id' => $id,
        'name' => $name,
        'age' => $age
    ];

    file_put_contents('users.json', json_encode($allUsers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo json_encode([
        'success' => true,
        'message' => 'Foydalanuvchi muvaffaqiyatli qo\'shildi.',
        'data' => [
            'id' => $id,
            'name' => $name,
            'age' => $age
        ]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Noto\'g\'ri so\'rov yuborildi.'
    ]);
    exit;
}