<?php
header('Content-Type: application/json');

$college = $_GET['college'] ?? '';
$course = $_GET['course'] ?? '';

$owner = 'ComradeMohan';
$repo = 'API';

// URL encode college and course to handle spaces and special chars
$collegeEnc = rawurlencode($college);
$courseEnc = rawurlencode($course);

// GitHub API URL to get contents of folder
$apiUrl = "https://api.github.com/repos/$owner/$repo/contents/uploads/$collegeEnc/$courseEnc";

$options = [
    "http" => [
        "header" => "User-Agent: UniValutApp\r\n"  // required by GitHub API
    ]
];

$context = stream_context_create($options);
$response = @file_get_contents($apiUrl, false, $context);

if ($response === false) {
    echo json_encode(["success" => false, "message" => "Failed to fetch data from GitHub API or directory not found"]);
    exit;
}

$data = json_decode($response, true);

if (isset($data['message'])) {
    // API returned an error, e.g., path not found
    echo json_encode(["success" => false, "message" => $data['message']]);
    exit;
}

$files = [];

foreach ($data as $file) {
    if (isset($file['name']) && preg_match('/\.pdf$/i', $file['name'])) {
        // Use GitHub raw file url to serve the PDF directly
        // The raw URL format is:
        // https://raw.githubusercontent.com/{owner}/{repo}/main/{path}
        $proxyUrl = "https://api-9buk.onrender.com/proxy_pdf.php?college=" . urlencode($college) . "&course=" . urlencode($course) . "&file=" . urlencode($file['name']);

        $files[] = [
            "name" => $file['name'],
            "url" => $rawUrl,
            "date" => ""  // GitHub API doesn't provide last modified date here
        ];
    }
}

echo json_encode(["success" => true, "files" => $files]);
?>
