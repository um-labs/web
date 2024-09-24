<?php
// 设置存储文件的路径
$file = 'contents.txt';

// 检查是否有 `action` 参数
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action === 'set') {
        // 如果是 'set' 操作，获取原始POST数据
        $json_data = file_get_contents('php://input');

        // 尝试解析JSON数据，确保数据是合法的JSON
        $data = json_decode($json_data, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            // 将数据保存到文件
            file_put_contents($file, $json_data);

            // 返回成功响应
            echo "Data saved successfully.";
        } else {
            // 如果JSON无效，返回HTTP 400错误
            http_response_code(400);
            echo "Invalid JSON data.";
        }
    } elseif ($action === 'get') {
        // 如果是 'get' 操作，读取并返回文件内容
        if (file_exists($file)) {
            $saved_data = file_get_contents($file);
            header('Content-Type: application/json');
            echo $saved_data;
        } else {
            // 如果文件不存在，返回404
            http_response_code(404);
            echo "No data found.";
        }
    } else {
        // 对于其他action返回HTTP 500
        http_response_code(500);
        echo "Internal Server Error.";
    }
} else {
    // 如果没有提供action，返回HTTP 500
    http_response_code(500);
    echo "Internal Server Error.";
}
