<?php

$library = [
    "Fiction" => [
        "Fantasy" => ["Harry Potter", "The Hobbit"],
        "Mystery" => ["Sherlock Holmes", "Gone Girl"]
    ],
    "Non-Fiction" => [
        "Science" => ["A Brief History of Time", "The Selfish Gene"],
        "Biography" => ["Steve Jobs", "Becoming"]
    ]
];

/**
 * Display a hierarchical library array as nested HTML lists.
 *
 * @param array $library The associative array of categories and books.
 * @param bool $isSub Whether this is a subcategory call (used for indentation/styling).
 */
function displayLibrary(array $library, bool $isSub = false): void {
    echo '<ul class="list-unstyled' . ($isSub ? ' ms-3 mb-1' : ' mb-2') . '">';
    
    foreach ($library as $key => $value) {
        if (is_array($value)) {
            // Category header
            echo '<li>';
            echo '<span class="fw-bold text-primary">' . htmlspecialchars($key) . '</span>';
            // Recursive call for subcategories or books
            displayLibrary($value, true);
            echo '</li>';
        } else {
            // Book title (leaf node)
            echo '<li class="text-muted"><i class="bi bi-book me-1"></i>' . htmlspecialchars($value) . '</li>';
        }
    }
    
    echo '</ul>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Catalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; padding: 2rem; }
        .text-primary { color: #2b6cb0 !important; }
        .text-muted { color: #718096 !important; }
        .fw-bold { font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4 text-center">📚 Library Catalog</h1>
        <?php displayLibrary($library); ?>
    </div>
</body>
</html>
