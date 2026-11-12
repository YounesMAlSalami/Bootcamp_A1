<?php
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$headers = function_exists('getallheaders') ? getallheaders() : [];
$authorization = $headers['Authorization'] ?? $headers['authorization'] ?? null;

$input = file_get_contents("php://input");
$data = null;

if ($input !== false && trim($input) !== "") {
    $data = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        $response = [
            "status" => "error",
            "message" => "Invalid JSON body",
            "error" => json_last_error_msg()
        ];

        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }
}

$response = [
    "status" => "success",
    "method" => $method,
    "message" => "",
    "data" => null,
    "headers" => [
        "authorization" => $authorization !== null ? "Present" : "Not provided"
    ]
];

switch ($method) {
    case "GET":
        http_response_code(200);
        $response["message"] = "GET request received successfully";
        $response["data"] = $_GET;
        break;

    case "POST":
        http_response_code(201);
        $response["message"] = "POST request received successfully";
        $response["data"] = $data;
        break;

    case "PUT":
        http_response_code(200);
        $response["message"] = "PUT request received successfully";
        $response["data"] = $data;
        break;

    case "DELETE":
        http_response_code(200);
        $response["message"] = "DELETE request received successfully";
        $response["data"] = $data;
        break;

    default:
        http_response_code(405);
        header("Allow: GET, POST, PUT, DELETE");
        $response["status"] = "error";
        $response["message"] = "Method not allowed";
        $response["allowed_methods"] = ["GET", "POST", "PUT", "DELETE"];
        break;
}

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>