<?php
// ---------------------------------------------
// Book data (could later come from a JSON or DB)
// ---------------------------------------------
$bookInfo = [
    "Harry Potter" => [
        "author" => "J.K. Rowling",
        "year" => 1997,
        "genre" => "Fantasy"
    ],
    "The Hobbit" => [
        "author" => "J.R.R. Tolkien",
        "year" => 1937,
        "genre" => "Fantasy"
    ],
    "Gone Girl" => [
        "author" => "Gillian Flynn",
        "year" => 2012,
        "genre" => "Mystery"
    ],
    "A Brief History of Time" => [
        "author" => "Stephen Hawking",
        "year" => 1988,
        "genre" => "Science"
    ]
];

// ---------------------------------------------
// Function to get book information safely
// ---------------------------------------------
function getBookInfo(string $title, array $bookInfo): string {
    if (isset($bookInfo[$title])) {
        $book = $bookInfo[$title];
        return "
            <div class='card shadow-sm border-0 mt-4'>
                <div class='card-body'>
                    <h4 class='card-title text-primary mb-3'>📖 " . htmlspecialchars($title) . "</h4>
                    <p class='mb-1'><strong>Author:</strong> " . htmlspecialchars($book['author']) . "</p>
                    <p class='mb-1'><strong>Year:</strong> " . htmlspecialchars($book['year']) . "</p>
                    <p class='mb-0'><strong>Genre:</strong> " . htmlspecialchars($book['genre']) . "</p>
                </div>
            </div>
        ";
    } else {
        return "<p class='text-danger mt-3'>❌ Book not found.</p>";
    }
}

// ---------------------------------------------
// Handle user selection from dropdown
// ---------------------------------------------
$selectedBook = $_GET['book'] ?? '';
$result = $selectedBook ? getBookInfo($selectedBook, $bookInfo) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Info Viewer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; padding: 2rem; }
        .card-title { color: #1d4ed8; }
        select { max-width: 300px; }
    </style>
</head>
<body>
    <div class="container text-center">
        <h1 class="mb-4 text-primary">📚 Book Information Lookup</h1>

        <!-- Dropdown Form -->
        <form method="get" class="d-flex justify-content-center">
            <select name="book" class="form-select me-2" required>
                <option value="">-- Select a Book --</option>
                <?php foreach ($bookInfo as $title => $info): ?>
                    <option value="<?= htmlspecialchars($title) ?>" <?= ($selectedBook === $title) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($title) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary">Show Info</button>
        </form>

        <!-- Display Result -->
        <div class="d-flex justify-content-center">
            <div style="max-width: 500px; width: 100%;">
                <?= $result ?>
            </div>
        </div>
    </div>
</body>
</html>
