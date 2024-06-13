<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Fast</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font-->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Librerias-->
    <link href="../pluggins/lib/animate/animate.min.css" rel="stylesheet">

    <!-- Bootstrap-->
    <link href="../styles/bootstrap.min.css" rel="stylesheet">

    <!-- style -->
    <link href="../styles/landingStyles.css" rel="stylesheet">

</head>

<body>
    <div class="container-xxl  p-0">

        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <img src="../imgs/LOGOf.png" alt="Logo" width="200">
                </a>
                <button class="navbar-toggler navbar-toggler-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0 pe-4">
                        <a href="#hero-header" class="nav-item nav-link">Home</a>
                        <a href="#beneficios" class="nav-item nav-link">Funciones</a>
                        <a href="#acerca-de" class="nav-item nav-link">Acerca</a>
                        <a href="#contact" class="nav-item nav-link">Contáctanos</a>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="views/sign-up/signup.html" class="btn btn-primary py-2 px-4 me-3">Prueba</a>
                        <a href="<?php echo constant('URL')?>login" class="btn btn-primary py-2 px-4">Iniciar sesión</a>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Hero Header -->
        <div id="hero-header" class="hero-header container-xxl-fluid py-5 mb-5 d-flex align-items-center justify-content-center">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class="display-4 text-primary mb-4 animated slideInRight trabajos-title">¡Potencia tu Restaurante con FAST!</h1>
                        <p class="lead mb-4 animated fadeInLeft delay-1s">Mejora la eficiencia de tu restaurante con nuestro software especializado en la gestión de pedidos, ventas, inventario y facturación.</p>
                        <a href="#" class="btn btn-primary btn-lg animated fadeInUp delay-2s">Prueba gratis FAST</a>
                    </div>
                    <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                        <img class="img-fluid rounded hero-image animated fadeInRight delay-1s" src="../imgs/img/uno.png" alt="hero">
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- beneficio -->

    <section id="beneficios" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-title mb-4">Beneficios de FAST para tu Restaurante</h2>
                    <p class="section-subtitle mb-5">Descubre cómo FAST puede ayudar a mejorar tu negocio</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="beneficio-item text-center mb-5 p-4 shadow rounded">
                        <i class="fas fa-cogs fa-4x mb-3 text-primary"></i>
                        <h3 class="mb-3">Eficiencia Mejorada</h3>
                        <p class="mb-0">Simplifica la gestión diaria con herramientas intuitivas que optimizan el flujo de trabajo de tu equipo.</p>
                    </div>
                    <div class="beneficio-item text-center p-4 shadow rounded">
                        <i class="fas fa-chart-line fa-4x mb-3 text-primary"></i>
                        <h3 class="mb-3">Análisis Detallados</h3>
                        <p class="mb-0">Accede a análisis detallados sobre el rendimiento de tu restaurante para tomar decisiones informadas.</p>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="beneficio-item text-center mb-5 p-4 shadow rounded">
                        <i class="fas fa-clipboard-check fa-4x mb-3 text-primary"></i>
                        <h3 class="mb-3">Precisión en los Pedidos</h3>
                        <p class="mb-0">Evita errores y reduce los tiempos de espera con un sistema de pedidos preciso y eficiente.</p>
                    </div>
                    <div class="beneficio-item text-center p-4 shadow rounded">
                        <i class="fas fa-coins fa-4x mb-3 text-primary"></i>
                        <h3 class="mb-3">Ahorro de Costos</h3>
                        <p class="mb-0">Optimiza tus gastos y aumenta tu rentabilidad con una gestión eficiente de recursos y procesos.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <!-- acerca de nosotros -->
    <section id="acerca-de" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 order-lg-1">
                    <h2 class="section-title mb-4">Acerca de FAST</h2>
                    <p class="section-subtitle mb-4">En FAST, nos apasiona ayudar a los restaurantes a alcanzar su máximo potencial. Fundada por un equipo de expertos en tecnología y restauración, nuestra misión es proporcionar soluciones innovadoras que simplifiquen la gestión diaria y mejoren el rendimiento operativo.</p>
                    <h3 class="about-subtitle mb-3">Nuestra Historia</h3>
                    <p class="about-content mb-4">Desde nuestro inicio, nos comprometimos a crear un software intuitivo que aborde los desafíos específicos de los restaurantes.</p>
                    <h3 class="about-subtitle mb-3">Nuestro Equipo</h3>
                    <p class="about-content mb-4">Con un equipo diverso y altamente cualificado, nos enorgullece ofrecer un servicio excepcional a nuestros clientes. Cada miembro aporta una perspectiva única y valiosa.</p>
                </div>
                <div class="col-lg-6 order-lg-2 team-image">
                    <!-- imagen  -->
                </div>
            </div>
        </div>
    </section>
    



<!-- caracteristicas -->
<section id="fast-features" class="py-5">
    <div class="container d-flex align-items-center">
        <div class="row">
            <div class="col-md-6">
                <div class="section-image">
                    <img src="../imgs/img/caracteristicas.png" alt="Imagen de Características">
                </div>
            </div>
            <div class="col-md-6">
                <div class="section-content">
                    <h3 class="subsection-title">Software Potente y Flexible</h3>
                    <p>Fast ofrece un software potente y flexible que se adapta a las necesidades únicas de tu restaurante. Desde la gestión de inventario hasta la programación de empleados, Fast tiene todo lo que necesitas para llevar tu negocio al siguiente nivel.</p>
                    <h3 class="subsection-title">Optimiza la Gestión de tu Restaurante con FAST</h3>
                    <p>Con la información adecuada a tu alcance, puedes tomar decisiones informadas y estratégicas que impulsen el crecimiento de tu restaurante.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- preguntas frecuentes -->

<section id="faq" class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Preguntas Frecuentes sobre FAST</h2>
        <div class="faq-list">
            <div class="faq-item">
                <div class="question">
                    <span class="question-text">1. ¿Qué es FAST y cómo puede ayudar a mi restaurante?</span>
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </div>
                <div class="answer">
                    <p>FAST es un software de gestión diseñado específicamente para restaurantes. Ayuda a simplificar la gestión diaria de pedidos, ventas, inventario y facturación, lo que mejora la eficiencia y el rendimiento operativo de tu restaurante.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="question">
                    <span class="question-text">2. ¿Es FAST adecuado para mi tipo de restaurante?</span>
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </div>
                <div class="answer">
                    <p>FAST es ideal para una amplia variedad de restaurantes, desde pequeños negocios familiares hasta cadenas de restaurantes. Nuestro software es altamente adaptable y puede personalizarse para satisfacer las necesidades específicas de tu restaurante.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="question">
                    <span class="question-text">3. ¿Es difícil de usar FAST?</span>
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </div>
                <div class="answer">
                    <p>No, FAST está diseñado con una interfaz intuitiva y fácil de usar. Ofrecemos capacitación y soporte técnico para garantizar que puedas aprovechar al máximo todas las funciones de nuestro software.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="question">
                    <span class="question-text">4. ¿Cómo puedo obtener soporte técnico si tengo algún problema?</span>
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </div>
                <div class="answer">
                    <p>Ofrecemos soporte técnico dedicado a través de correo electrónico. Nuestro equipo de expertos está disponible para ayudarte con cualquier pregunta o problema que puedas tener.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="question">
                    <span class="question-text">5. ¿Hay algún costo adicional aparte del precio del software?</span>
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </div>
                <div class="answer">
                    <p>El costo de FAST incluye todas las actualizaciones de software y soporte técnico. No hay costos ocultos ni tarifas adicionales.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="question">
                    <span class="question-text">6. ¿Puedo probar FAST antes de comprarlo?</span>
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </div>
                <div class="answer">
                    <p>Sí, ofrecemos una demostración gratuita de FAST para que puedas ver cómo funciona nuestro software y cómo puede beneficiar a tu restaurante.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- contactos -->

<section id="contact" class="py-5">
    <div class="container contact-container">
        <h2 class="contact-title">¿Tienes alguna pregunta sobre FAST?</h2>
        <p class="contact-text">¿O estás interesado en saber más sobre cómo puede beneficiar a tu restaurante? ¡Estamos aquí para ayudarte!</p>
        <form action="#" method="post" class="contact-form">
            <div class="form-group">
                <input type="email" class="form-control contact-email" id="email" name="email" placeholder="Ingresa tu correo electrónico" required>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-registrarse">Inicia tu prueba gratis</button>
            <p class="small confirm-message">Al hacer clic en Regístrate, confirmas que estás de acuerdo con el tratamiento de tus datos.</p>
        </form>
    </div>
</section>

<!-- footer -->

<footer id="footer">
    <div class="footer-container">
        <div class="footer-row">
            <div class="footer-column footer-links-column">
                <h4 class="footer-column-title">Enlaces Rápidos</h4>
                <ul class="footer-links-list">
                    <li><a href="#hero-header">Inicio</a></li>
                    <li><a href="#beneficios">Funcionalidades</a></li>
                    <li><a href="#acerca-de">Acerca de Nosotros</a></li>
                    <li><a href="#faq">Preguntas Frecuentes</a></li>
                    <li><a href="#contact">Contáctanos</a></li>

                </ul>
            </div>

            <div class="footer-column footer-contact-column">
                <h4 class="footer-column-title">Información de Contacto</h4>
                <p class="footer-contact-info">
                    Correo Electrónico: <a href="mailto:info@fastrestaurant.com">info@fastrestaurant.com</a><br>
                    Teléfono: <a href="tel:+15551234567">+1 (555) 123-4567</a>
                </p>
            </div>

            <div class="footer-column footer-social-column">
                <h4 class="footer-column-title">Redes Sociales</h4>
                <p class="footer-social-description">Síguenos en nuestras redes sociales para obtener las últimas actualizaciones y noticias sobre FAST.</p>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>







    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class='bx bx-up-arrow-alt'></i></a>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../pluggins/lib/wow/wow.min.js"></script>
<script src="../pluggins/lib/easing/easing.min.js"></script>
<script src="../pluggins/lib/waypoints/waypoints.min.js"></script>
<script src="../js/main.js"></script>
<script src="../js/landing.js"></script>

</body>

</html>