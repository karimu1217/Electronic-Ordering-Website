<footer class="footer">
    <div class="footer-content">
        <p>&copy; <?= date('Y') ?> Kobbie Tonics. All rights reserved.</p>
        <p>Dar es Salaam, Tanzania | 
           <a href="contact.php">Contact Us</a> | 
           <a href="about.php">About Us</a>
        </p>
    </div>
</footer>

<style>
    .footer {
        background: #2c3e50;
        color: white;
        text-align: center;
        padding: 40px 20px 20px;
        margin-top: 60px; /* space juu ili isiingie content */
        border-top: 4px solid #27ae60;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer p {
        margin: 10px 0;
        font-size: 15px;
    }

    .footer a {
        color: #27ae60;
        text-decoration: none;
        margin: 0 12px;
        transition: color 0.3s;
    }

    .footer a:hover {
        color: #2ecc71;
        text-decoration: underline;
    }

    /* Hakuna fixed – footer inakuja chini ya content kawaida */
</style>