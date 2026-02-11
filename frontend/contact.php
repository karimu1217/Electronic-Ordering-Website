<?php include 'header.php'; ?>

<div class="contact-container">
    <h1>Contact Us / Location</h1>

    <div class="contact-grid">
        <!-- Maandishi kushoto -->
        <div class="contact-info">
            <p><strong>WhatsApp:</strong> +255 678 899 408</p>
            <p><strong>Barua pepe:</strong> 1217kareem@gmail.com</p>
            <p><strong>Anwani:</strong> Mkabala na Bibititi Mohamed Road, Dar es Salaam</p>
            <p><strong>Mahali:</strong> Karibu na College of Business Education (CBE), Posta Mpya</p>
        </div>

        <!-- Ramani kulia - inaelekeza CBE Dar es Salaam -->
        <div class="contact-map">
            <h2>Map: College of Business Education (CBE)</h2>
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.143!2d39.285!3d-6.809!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185c4a!2sCollege%20of%20Business%20Education%20(CBE)!5e0!3m2!1sen!2stz!4v1739000000000!5m2!1sen!2stz" 
                width="100%" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>



<style>
    .contact-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: start;
    }

    .contact-info {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .contact-info p {
        font-size: 18px;
        margin: 15px 0;
        line-height: 1.6;
    }

    .contact-info strong {
        color: #2c3e50;
    }

    .contact-map {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .contact-map h2 {
        margin-top: 0;
        color: #2c3e50;
    }

    /* Responsive - simu ndogo */
    @media (max-width: 768px) {
        .contact-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .contact-map iframe {
            height: 350px;
        }
    }
</style>
<?php include 'footer.php'; ?>