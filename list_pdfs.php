<?php
header('Content-Type: application/json');

// Get college and course from GET parameters
$college = $_GET['college'] ?? '';
$course = $_GET['course'] ?? '';

if (empty($college) || empty($course)) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required parameters."
    ]);
    exit;
}

$owner = 'ComradeMohan';
$repo = 'API';

// URL encode to handle spaces and special characters
$collegeEnc = rawurlencode($college);
$courseEnc = rawurlencode($course);

// GitHub API URL to list contents of the folder for that college and course
$apiUrl = "https://api.github.com/repos/$owner/$repo/contents/uploads/$collegeEnc/$courseEnc";

// Setup HTTP headers including User-Agent (required by GitHub)
$options = [
    "http" => [
        "header" => "User-Agent: UniValutApp\r\n"
    ]
];

$context = stream_context_create($options);

// Fetch contents from GitHub API
$response = @file_get_contents($apiUrl, false, $context);

if ($response === false) {
    echo json_encode([
        "success" => false,
        "message" => "Failed to fetch data from GitHub API or directory not found"
    ]);
    exit;
}

$data = json_decode($response, true);

if (isset($data['message'])) {
    // GitHub API error message (e.g., directory doesn't exist)
    echo json_encode([
        "success" => false,
        "message" => $data['message']
    ]);
    exit;
}

$files = [];

foreach ($data as $file) {
    // Filter only PDF files
    if (isset($file['name']) && preg_match('/\.pdf$/i', $file['name'])) {
        // Construct raw GitHub URL to serve the PDF directly
        $rawUrl = "https://raw.githubusercontent.com/$owner/$repo/main/uploads/$collegeEnc/$courseEnc/" . rawurlencode($file['name']);
        
        $files[] = [
            "name" => $file['name'],
            "url" => $rawUrl,
            "date" => ""  // GitHub API doesn't provide last modified date here
        ];
    }
}

echo json_encode([
    "success" => true,
    "files" => $files
]);
?>
