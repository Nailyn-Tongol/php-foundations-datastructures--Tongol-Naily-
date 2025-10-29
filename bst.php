<?php
// ---------------------------------------------
// Node class representing each element in the BST
// ---------------------------------------------
class Node {
    public string $data;
    public ?Node $left;
    public ?Node $right;

    public function __construct(string $data) {
        $this->data = $data;
        $this->left = null;
        $this->right = null;
    }
}

// ---------------------------------------------
// Binary Search Tree Class
// ---------------------------------------------
class BinarySearchTree {
    public ?Node $root;

    public function __construct() {
        $this->root = null;
    }

    // Insert new data into BST
    public function insert(string $data): void {
        $this->root = $this->insertRec($this->root, $data);
    }

    private function insertRec(?Node $node, string $data): Node {
        if ($node === null) {
            return new Node($data);
        }

        if (strcasecmp($data, $node->data) < 0) {
            $node->left = $this->insertRec($node->left, $data);
        } elseif (strcasecmp($data, $node->data) > 0) {
            $node->right = $this->insertRec($node->right, $data);
        }

        return $node;
    }

    // Search for a title
    public function search(string $data): bool {
        return $this->searchRec($this->root, $data);
    }

    private function searchRec(?Node $node, string $data): bool {
        if ($node === null) {
            return false;
        }

        if (strcasecmp($data, $node->data) === 0) {
            return true;
        }

        if (strcasecmp($data, $node->data) < 0) {
            return $this->searchRec($node->left, $data);
        }

        return $this->searchRec($node->right, $data);
    }

    // Inorder Traversal (returns array)
    public function inorderTraversal(?Node $node, array &$result): void {
        if ($node !== null) {
            $this->inorderTraversal($node->left, $result);
            $result[] = $node->data;
            $this->inorderTraversal($node->right, $result);
        }
    }

    // Get inorder list as HTML (for display)
    public function getInorderList(): string {
        $result = [];
        $this->inorderTraversal($this->root, $result);
        $output = "<ul class='list-group'>";
        foreach ($result as $title) {
            $output .= "<li class='list-group-item'>" . htmlspecialchars($title) . "</li>";
        }
        $output .= "</ul>";
        return $output;
    }
}

// ---------------------------------------------
// Demonstration
// ---------------------------------------------
$bst = new BinarySearchTree();
$books = [
    "Harry Potter",
    "The Hobbit",
    "Gone Girl",
    "A Brief History of Time",
    "Sherlock Holmes",
    "Becoming"
];

// Insert all books into BST
foreach ($books as $title) {
    $bst->insert($title);
}

// Handle search query from form
$searchResult = "";
if (isset($_GET['query']) && $_GET['query'] !== '') {
    $query = trim($_GET['query']);
    $found = $bst->search($query);
    $searchResult = "<div class='mt-3 alert " . ($found ? "alert-success" : "alert-danger") . "'>
        <strong>" . htmlspecialchars($query) . ":</strong> " . ($found ? "Found in the library!" : "Not found in the library.") . "
    </div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Binary Search Tree - Book Titles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; padding: 2rem; }
        .container { max-width: 700px; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4 text-primary">📚 Binary Search Tree (Book Titles)</h1>

        <h4 class="mb-3">Inorder Traversal (Alphabetical Order)</h4>
        <?= $bst->getInorderList(); ?>

        <hr>

        <h4 class="mb-3">🔍 Search for a Book</h4>
        <form method="get" class="d-flex mb-3">
            <input type="text" name="query" class="form-control me-2" placeholder="Enter book title..." value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
            <button class="btn btn-primary">Search</button>
        </form>

        <?= $searchResult ?>
    </div>
</body>
</html>
