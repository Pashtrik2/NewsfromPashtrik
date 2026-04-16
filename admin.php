<?php
session_start();
$_SESSION['role'] = 'admin';
$pageTitle = 'Admin Dashboard';
include 'header.php';
require_once __DIR__ . '/app/database.php';
require_once __DIR__ . '/app/Product.php';
require_once __DIR__ . '/app/News.php';
require_once __DIR__ . '/app/ContactMessage.php';
?>
<section class="hero">
    <div class="hero-copy">
        <span class="hero-badge">Admin</span>
        <h2 class="hero-title">Control the content from one place</h2>
        <p class="hero-text">Manage products, publish news, and review incoming messages from a tighter two-column dashboard.</p>
    </div>
</section>

<section class="section-shell">
    <div class="section-heading">
        <div>
            <p class="section-kicker">Dashboard</p>
            <h2 class="section-title">Editorial workspace</h2>
        </div>
        <p class="section-description">All management tools stay aligned in cards so the dashboard feels cleaner and easier to scan.</p>
    </div>

    <div class="admin-grid">
        <article class="table-card">
            <h3>Products</h3>
            <form method="post" class="toolbar-form">
                <input type="text" name="product_name" placeholder="Name" required>
                <input type="text" name="product_description" placeholder="Description" required>
                <input type="number" step="0.01" name="product_price" placeholder="Price" required>
                <input type="text" name="product_image" placeholder="Image URL">
                <button type="submit" name="add_product">Add Product</button>
            </form>
            <div class="table-scroll">
                <table class="user-table">
                    <tr><th>Name</th><th>Description</th><th>Price</th><th>Image</th><th>Actions</th></tr>
                    <?php
                    $productObj = new Product($conn);
                    $products = $productObj->read();
                    while ($row = $products->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr><form method="post">
                        <td><input type="text" name="product_name" value="<?= htmlspecialchars($row['name']) ?>"></td>
                        <td><input type="text" name="product_description" value="<?= htmlspecialchars($row['description']) ?>"></td>
                        <td><input type="number" step="0.01" name="product_price" value="<?= htmlspecialchars($row['price']) ?>"></td>
                        <td><input type="text" name="product_image" value="<?= htmlspecialchars($row['image']) ?>"></td>
                        <td>
                            <div class="table-actions">
                                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="edit_product">Edit</button>
                                <button type="submit" name="delete_product" onclick="return confirm('Delete?')">Delete</button>
                            </div>
                        </td>
                    </form></tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </article>

        <article class="table-card">
            <h3>News</h3>
            <form method="post" class="toolbar-form">
                <input type="text" name="news_title" placeholder="Title" required>
                <input type="text" name="news_content" placeholder="Content" required>
                <input type="text" name="news_image" placeholder="Image URL">
                <button type="submit" name="add_news">Add News</button>
            </form>
            <div class="table-scroll">
                <table class="user-table">
                    <tr><th>Title</th><th>Content</th><th>Image</th><th>Created By</th><th>Actions</th></tr>
                    <?php
                    $newsObj = new News($conn);
                    $news = $newsObj->read();
                    while ($row = $news->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr><form method="post">
                        <td><input type="text" name="news_title" value="<?= htmlspecialchars($row['title']) ?>"></td>
                        <td><input type="text" name="news_content" value="<?= htmlspecialchars($row['content']) ?>"></td>
                        <td><input type="text" name="news_image" value="<?= htmlspecialchars($row['image']) ?>"></td>
                        <td><?= htmlspecialchars($row['created_by']) ?></td>
                        <td>
                            <div class="table-actions">
                                <input type="hidden" name="news_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="edit_news">Edit</button>
                                <button type="submit" name="delete_news" onclick="return confirm('Delete?')">Delete</button>
                            </div>
                        </td>
                    </form></tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </article>

        <article class="table-card admin-grid-full">
            <h3>Contact Messages</h3>
            <div class="table-scroll">
                <table class="user-table">
                    <tr><th>Name</th><th>Email</th><th>Message</th><th>Date</th></tr>
                    <?php
                    $contactObj = new ContactMessage($conn);
                    $messages = $contactObj->read();
                    while ($row = $messages->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['message']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </article>
    </div>
</section>
<?php include 'footer.php'; ?>