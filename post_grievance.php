<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '1234', 'grievance_portal');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO grievances (user_id, subject, description, status, created_at) 
            VALUES ('$user_id', '$subject', '$description', 'Pending', NOW())";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Grievance submitted successfully!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch user's grievances
$user_grievances_query = "SELECT subject, description, created_at FROM grievances 
                          WHERE user_id = '{$_SESSION['user_id']}' ORDER BY created_at DESC";
$user_grievances_result = $conn->query($user_grievances_query);

// Fetch all grievances (from all users)
$all_grievances_query = "SELECT g.subject, g.description, g.status, g.created_at, u.name 
                         FROM grievances g 
                         JOIN users u ON g.user_id = u.id
                         ORDER BY g.created_at DESC";
$all_grievances_result = $conn->query($all_grievances_query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Post Grievance</title>
    <link rel="stylesheet" href="post_grievance.css">
</head>
<body>
    <div class="container">
        <h1>Post a Grievance</h1>

        <!-- Display user's grievances -->
        <div class="grievance-list">
            <h2>Your Grievances</h2>
            <?php if ($user_grievances_result->num_rows > 0): ?>
                <ul>
                    <?php while ($row = $user_grievances_result->fetch_assoc()): ?>
                        <li>
                            <h3><?php echo htmlspecialchars($row['subject']); ?></h3>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                            <span><?php echo date("F j, Y, g:i a", strtotime($row['created_at'])); ?></span>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No grievances found. Submit your first grievance below!</p>
            <?php endif; ?>
        </div>

        <!-- Grievance submission form -->
        <form class="grievance-form" method="POST">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            
            <button type="submit">Submit</button>
        </form>
    </div>

    <!-- Display all grievances -->
    <div class="all-grievances">
        <h2>All Grievances</h2>
        <?php if ($all_grievances_result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $all_grievances_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo date("F j, Y, g:i a", strtotime($row['created_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No grievances have been posted yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
