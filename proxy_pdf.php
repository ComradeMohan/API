<?php
// proxy_pdf.php

$owner = 'ComradeMohan';
$repo = 'API';
$branch = 'main';

// Get parameters
$college = $_GET['college'] ?? '';
$course = $_GET['course'] ?? '';
$file = $_GET['file'] ?? '';

// Validate parameters
if (!$college || !$course || !$file) {
    http_response_code(400);
    echo "Missing parameters";
    exit;
}

// Build raw GitHub URL
function buildGithubRawUrl($owner, $repo, $branch, $pathParts) {
    $encodedParts = array_map('rawurlencode', $pathParts);
    $path = implode('/', $encodedParts);
    return "https://raw.githubusercontent.com/$owner/$repo/$branch/$path";
}

$url = buildGithubRawUrl($owner, $repo, $branch, ['uploads', $college, $course, $file]);

// Fetch PDF content with proper user agent for GitHub
$options = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: UniValutApp\r\n"
    ]
];
$context = stream_context_create($options);
$fileContent = @file_get_contents($url, false, $context);

if ($fileContent === false) {
    http_response_code(404);
    echo "File not found";
    exit;
}

// Output PDF with inline headers so browser/app can view it inline
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . basename($file) . '"');
header('Content-Length: ' . strlen($fileContent));

echo $fileContent;
?>
