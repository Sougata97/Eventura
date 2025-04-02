<?php
include 'includes/db.php';

$query = $_GET['query'] ?? '';
$events = [];

if ($query) {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE name LIKE ? OR location LIKE ?");
    $stmt->execute(['%' . $query . '%', '%' . $query . '%']);
    $events = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Results</title>
</head>
<body>
    <h2>Search Events</h2>
    <form method="GET" action="search.php">
        <input type="text" name="query" value="<?php echo htmlspecialchars($query); ?>" placeholder="Search by name or location">
        <button type="submit">Search</button>
    </form>

    <?php if ($query && $events): ?>
        <ul>
            <?php foreach ($events as $event): ?>
                <li>
                    <a href="events/details.php?id=<?php echo $event['id']; ?>">
                        <?php echo htmlspecialchars($event['name']); ?>
                    </a> on <?php echo htmlspecialchars($event['event_date']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php elseif ($query): ?>
        <p>No results found for "<?php echo htmlspecialchars($query); ?>"</p>
    <?php endif; ?>
</body>
</html>
