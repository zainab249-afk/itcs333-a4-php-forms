<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/validate.php';

$errors = [];
$old = ['name' => '', 'email' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['name']    = trim($_POST['name'] ?? '');
    $old['email']   = trim($_POST['email'] ?? '');
    $old['message'] = trim($_POST['message'] ?? '');

    if (!validate_required($old['name'])) {
        $errors['name'] = "Name is required.";
    } elseif (!validate_length($old['name'], 2, 60)) {
        $errors['name'] = "Name must be between 2 and 60 characters.";
    }

    if (!validate_required($old['email'])) {
        $errors['email'] = "Email is required.";
    } elseif (!validate_email($old['email'])) {
        $errors['email'] = "Invalid email format.";
    }

    if (!validate_required($old['message'])) {
        $errors['message'] = "Message is required.";
    } elseif (!validate_length($old['message'], 10, 1000)) {
        $errors['message'] = "Message must be between 10 and 1000 characters.";
    }

    if (empty($errors)) {
        header('Location: success.php', true, 303);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Contact Us</title>
</head>
<body>
<h1>Contact Us</h1>

<?php if (!empty($errors)): ?>
    <div style="color: red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="index.php">
    <label>Name
        <input type="text" name="name" value="<?= htmlspecialchars($old['name']) ?>">
    </label><br>
    
    <label>Email
        <input type="email" name="email" value="<?= htmlspecialchars($old['email']) ?>">
    </label><br>
    
    <label>Message
        <textarea name="message"><?= htmlspecialchars($old['message']) ?></textarea>
    </label><br>
    
    <button type="submit">Send</button>
</form>

</body>
</html>