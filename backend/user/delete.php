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
    if (file_exists('users.json') && filesize('users.json') > 0) {
        $allUsers = json_decode(file_get_contents('users.json'), true);
    }

    foreach ($allUsers as $key => $user) {
        if ($user['id'] == $id) {
            unset($allUsers[$key]);
            file_put_contents('users.json', json_encode(array_values($allUsers)));
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
