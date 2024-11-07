<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<style>
    header {
    position: fixed;
    top: 0;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    color: #fff;
    display: flex;
    justify-content: center;
    padding: 1em 0;
    z-index: 1000;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.5);
    }
    header nav a {
    color: #ffffff;
    margin: 0 20px;
    text-decoration: none;
    font-weight: bold;
    font-size: 1.1rem;
    letter-spacing: 0.5px;
    transition: color 0.3s ease, text-decoration 0.3s ease;
}

header nav a:hover {
    color: #ff5252;
    text-decoration: underline;
}

</style>
<header>
    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact</a>

        <?php if ($current_page === 'index.php'): ?>
            <?php if (isset($_SESSION['username'])): ?>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                | <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="signin.php">Sign In</a>
            <?php endif; ?>
        <?php endif; ?>
    </nav>
</header>
