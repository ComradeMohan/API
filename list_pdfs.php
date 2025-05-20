<?php
header('Content-Type: application/json');

$college = isset($_GET['college']) ? $_GET['college'] : '';
$course = isset($_GET['course']) ? $_GET['course'] : '';

if (empty($college) || empty($course)) {
    echo json_encode(["success" => false, "message" => "Missing parameters"]);
    exit;
}

$collegeEncoded = rawurlencode($college);
$courseEncoded = rawurlencode($course);

$githubApiUrl = "https://api.github.com/repos/ComradeMohan/API/contents/uploads/$collegeEncoded/$courseEncoded";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $githubApiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: UniValut-App'
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["success" => false, "message" => "Curl error: " . curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);

$data = json_decode($response, true);

if (isset($data['message'])) {
    echo json_encode(["success" => false, "message" => $data['message']]);
    exit;
}

$proxyBase = "https://api-9buk.onrender.com/proxy_pdf.php";
$responseArr = [];

foreach ($data as $file) {
    if ($file['type'] === 'file') {
        $responseArr[] = [
            "name" => $file['name'],
            "url" => $proxyBase . "?college=" . rawurlencode($college) . "&course=" . rawurlencode($course) . "&file=" . rawurlencode($file['name']),
            "size" => $file['size'],
            "html_url" => $file['html_url']
        ];
    }
}

echo json_encode(["success" => true, "files" => $responseArr]);
