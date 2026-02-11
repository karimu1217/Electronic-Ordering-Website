<?php include 'header.php'; ?>

<div class="about-container">
    <div class="about-hero">
        <h1>Kuhusu Kobbie Tonics</h1>
        <p class="tagline">Duka lako la kielektroniki la kuaminika, bei nafuu na ubora wa hali ya juu</p>
    </div>

    <div class="about-content">
        <section class="mission">
            <h2>Maono Yetu</h2>
            <p>Kobbie Tonics ni zaidi ya duka la bidhaa za kielektroniki — ni mfumo wa kuunganisha wateja na teknolojia bora kwa bei inayofikika. Tunajivunia kuleta simu mahiri, kompyuta, vifaa vya sauti, na vifaa vingine vya hali ya juu moja kwa moja kwenye milango yenu hapa Dar es Salaam na maeneo ya karibu.</p>
        </section>

        <section class="story">
            <h2>Hadithi Yetu</h2>
            <p>Tulianza Kobbie Tonics kwa shauku ya kuwapa Watanzania fursa ya kupata bidhaa za kielektroniki za ubora bila kulipa gharama kubwa. Tukiwa na makao makuu Dar es Salaam, tumekuwa tukikua haraka kwa sababu ya imani yetu katika huduma bora, usafirishaji wa haraka, na bei za ushindani. Leo, tunajivunia kuwa moja ya maduka yanayopendwa zaidi mtandaoni kwa wateja wanaotafuta thamani halisi.</p>
        </section>

        <section class="why-us">
            <h2>Kwa Nini Uchague Kobbie Tonics?</h2>
            <div class="why-grid">
                <div class="why-item">
                    <i class="fas fa-shipping-fast"></i>
                    <h3>Usafirishaji wa Haraka</h3>
                    <p>Tunasafirisha ndani ya Dar es Salaam na maeneo ya karibu kwa siku 1-2 tu.</p>
                </div>
                <div class="why-item">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Uhakika wa Ubora</h3>
                    <p>Bidhaa zote zinakuja na warranty na tunaangalia ubora kabla ya kuuzwa.</p>
                </div>
                <div class="why-item">
                    <i class="fas fa-hand-holding-usd"></i>
                    <h3>Bei za Ushindani</h3>
                    <p>Tunatoa bei bora zaidi sokoni bila kupunguza ubora.</p>
                </div>
                <div class="why-item">
                    <i class="fas fa-headset"></i>
                    <h3>Huduma ya Wateja 24/7</h3>
                    <p>Tuko tayari kukusaidia wakati wowote kupitia simu au barua pepe.</p>
                </div>
            </div>
        </section>

        <section class="team">
            <h2>Timu Yetu</h2>
            <p>Tuna timu ndogo lakini yenye shauku kubwa ya vijana wanaopenda teknolojia na huduma kwa wateja. Tunafanya kazi pamoja ili kuhakikisha kila agizo lako linafikia kwa wakati na katika hali nzuri.</p>
        </section>

        <section class="contact-cta">
            <h2>Tuko Tayari Kukusaidia!</h2>
            <p>Una swali au unahitaji ushauri wa bidhaa? Wasiliana nasi leo!</p>
            <a href="contact.php" class="cta-btn">Wasiliana Nasi</a>
        </section>
    </div>
</div>

<?php include 'footer.php'; ?>

<style>
    .about-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .about-hero {
        text-align: center;
        margin-bottom: 60px;
    }

    .about-hero h1 {
        font-size: 48px;
        color: #2c3e50;
        margin-bottom: 15px;
    }

    .about-hero .tagline {
        font-size: 20px;
        color: #27ae60;
        font-weight: 600;
    }

    .about-content section {
        margin-bottom: 60px;
    }

    .about-content h2 {
        color: #27ae60;
        font-size: 32px;
        margin-bottom: 20px;
        text-align: center;
    }

    .mission, .story, .team {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        font-size: 18px;
        line-height: 1.7;
        color: #555;
    }

    .why-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        margin-top: 30px;
    }

    .why-item {
        background: white;
        padding: 30px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        transition: transform 0.3s ease;
    }

    .why-item:hover {
        transform: translateY(-10px);
    }

    .why-item i {
        font-size: 48px;
        color: #27ae60;
        margin-bottom: 20px;
    }

    .why-item h3 {
        color: #2c3e50;
        margin-bottom: 15px;
    }

    .contact-cta {
        text-align: center;
        background: #27ae60;
        color: white;
        padding: 60px 20px;
        border-radius: 20px;
    }

    .contact-cta h2 {
        color: white;
        margin-bottom: 20px;
    }

    .cta-btn {
        display: inline-block;
        background: white;
        color: #27ae60;
        padding: 14px 35px;
        border-radius: 50px;
        font-weight: bold;
        font-size: 18px;
        text-decoration: none;
        margin-top: 20px;
        transition: all 0.3s ease;
    }

    .cta-btn:hover {
        background: #219653;
        color: white;
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .about-hero h1 {
            font-size: 36px;
        }
        .contact-grid {
            grid-template-columns: 1fr;
        }
    }
</style>