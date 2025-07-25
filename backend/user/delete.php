<?php

header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    if (empty($data['id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'ID maydoni to\'ldirilishi shart.'
        ]);
        exit;
    }

    $id = $data['id'];

    if (!is_numeric($id)) {
        echo json_encode([
            'success' => false,
            'message' => 'ID raqam bo\'lishi kerak.'
        ]);
        exit;
    }

    $allUsers = [];
    if (file_exists('../data/users.json') && filesize('../data/users.json') > 0) {
        $allUsers = json_decode(file_get_contents('../data/users.json'), true);
    }

    foreach ($allUsers as $key => $user) {
        if ($user['id'] == $id) {
            unset($allUsers[$key]);
            file_put_contents('../data/users.json', json_encode($allUsers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo json_encode([
                'success' => true,
                'message' => 'Foydalanuvchi muvaffaqiyatli o\'chirildi.'
            ]);
            exit;
        }
    }

    echo json_encode([
        'success' => false,
        'message' => 'Foydalanuvchi topilmadi.'
    ]);
    exit;

} else {
    echo json_encode([
        'success' => false,
        'message' => 'ID maydoni to\'ldirilishi shart.'
    ]);
    exit;
}
