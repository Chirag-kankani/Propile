<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $user['username'] ?>'s Creative Portfolio - ProPile</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        :root {
            --dark-void: #151419;
            --liquid-lava: #F58E0F;
            --gluon-grey: #1B1B1E;
            --slate-grey: #262626;
            --dusty-grey: #878787;
            --snow: #FBFBFB;
            
            --gradient-primary: linear-gradient(135deg, var(--liquid-lava) 0%, #e55b10 100%);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-void);
            background-color: var(--snow);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 2;
        }
        
        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 100;
            padding: 24px 0;
            background-color: transparent;
            transition: var(--transition);
        }
        
        nav.scrolled {
            background-color: var(--dark-void);
            padding: 16px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 28px;
            font-weight: 700;
            color: var(--snow);
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            gap: 32px;
        }
        
        .nav-links a {
            color: var(--snow);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .nav-links a:hover {
            color: var(--liquid-lava);
        }
        
        /* Hero Section */
        .hero {
            min-height: 100vh;
            background-color: var(--dark-void);
            color: var(--snow);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background: var(--gradient-primary);
            clip-path: polygon(30% 0, 100% 0, 100% 100%, 0% 100%);
            opacity: 0.1;
        }
        
        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            align-items: center;
        }
        
        .hero-content {
            padding-right: 24px;
        }
        
        .hero-subtitle {
            display: inline-block;
            padding: 8px 16px;
            background-color: rgba(245, 142, 15, 0.2);
            color: var(--liquid-lava);
            border-radius: 4px;
            font-weight: 500;
            margin-bottom: 24px;
        }
        
        .hero-title {
            font-size: 64px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 24px;
        }
        
        .hero-title span {
            color: var(--liquid-lava);
        }
        
        .hero-description {
            font-size: 18px;
            color: var(--dusty-grey);
            margin-bottom: 32px;
            max-width: 500px;
        }
        
        .hero-cta {
            display: inline-block;
            padding: 12px 32px;
            background: var(--gradient-primary);
            color: var(--snow);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .hero-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(245, 142, 15, 0.3);
        }
        
        .hero-image {
            position: relative;
        }
        
        .profile-image {
            width: 100%;
            aspect-ratio: 1;
            background-color: var(--liquid-lava);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 120px;
            color: var(--snow);
            position: relative;
            z-index: 1;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .profile-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--gradient-primary);
            z-index: -1;
        }
        
        .shape {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(245, 142, 15, 0.2);
            filter: blur(40px);
            z-index: -1;
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            top: -150px;
            right: -100px;
        }
        
        .shape-2 {
            width: 200px;
            height: 200px;
            bottom: -50px;
            left: -100px;
            background-color: rgba(27, 27, 30, 0.3);
        }
        
        /* About Section */
        .about {
            padding: 120px 0;
            position: relative;
            overflow: hidden;
        }
        
        .section-title {
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 16px;
            color: var(--dark-void);
        }
        
        .section-title span {
            color: var(--liquid-lava);
        }
        
        .section-subtitle {
            font-size: 18px;
            color: var(--dusty-grey);
            margin-bottom: 48px;
            max-width: 600px;
        }
        
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 64px;
            align-items: center;
        }
        
        .about-image {
            position: relative;
        }
        
        .about-img {
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            background-color: var(--slate-grey);
            aspect-ratio: 4/5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--snow);
            font-size: 32px;
        }
        
        .about-content p {
            margin-bottom: 24px;
            color: var(--slate-grey);
        }
        
        .about-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 24px;
            margin-top: 32px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 48px;
            font-weight: 700;
            color: var(--liquid-lava);
            line-height: 1;
            margin-bottom: 8px;
        }
        
        .stat-label {
            font-size: 16px;
            color: var(--dusty-grey);
        }
        
        /* Education Section */
        .education {
            padding: 120px 0;
            background-color: #f8f8f8;
            position: relative;
            overflow: hidden;
        }
        
        .timeline {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
            padding-left: 40px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--liquid-lava);
            border-radius: 2px;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 64px;
        }
        
        .timeline-item:last-child {
            margin-bottom: 0;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -51px;
            top: 0;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: var(--snow);
            border: 4px solid var(--liquid-lava);
            z-index: 1;
        }
        
        .timeline-date {
            font-size: 16px;
            font-weight: 500;
            color: var(--liquid-lava);
            margin-bottom: 8px;
        }
        
        .timeline-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark-void);
        }
        
        .timeline-subtitle {
            font-size: 18px;
            color: var(--slate-grey);
            margin-bottom: 16px;
        }
        
        .timeline-content {
            color: var(--dusty-grey);
        }
        
        /* Projects Section */
        .projects {
            padding: 120px 0;
            position: relative;
            overflow: hidden;
        }
        
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 32px;
            margin-top: 48px;
        }
        
        .project-card {
            background-color: var(--snow);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }
        
        .project-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .project-image {
            width: 100%;
            height: 220px;
            background-color: var(--slate-grey);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--snow);
            font-size: 24px;
            position: relative;
            overflow: hidden;
        }
        
        .project-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(21, 20, 25, 0.3), rgba(21, 20, 25, 0.8));
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 24px;
            opacity: 0;
            transition: var(--transition);
        }
        
        .project-card:hover .project-overlay {
            opacity: 1;
        }
        
        .project-overlay-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--snow);
            margin-bottom: 8px;
        }
        
        .project-category {
            color: var(--liquid-lava);
            font-weight: 500;
        }
        
        .project-content {
            padding: 24px;
        }
        
        .project-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark-void);
        }
        
        .project-description {
            color: var(--dusty-grey);
            margin-bottom: 24px;
        }
        
        .project-link {
            display: inline-block;
            color: var(--liquid-lava);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .project-link:hover {
            color: #e07c00;
        }
        
        /* Contact Section */
        .contact {
            padding: 120px 0;
            background-color: var(--dark-void);
            color: var(--snow);
            position: relative;
            overflow: hidden;
        }
        
        .contact::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background: var(--gradient-primary);
            clip-path: polygon(100% 0, 100% 100%, 0 100%, 70% 0);
            opacity: 0.1;
        }
        
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 64px;
            align-items: center;
        }
        
        .contact-content {
            position: relative;
            z-index: 1;
        }
        
        .contact-title {
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 16px;
            color: var(--snow);
        }
        
        .contact-title span {
            color: var(--liquid-lava);
        }
        
        .contact-text {
            color: var(--dusty-grey);
            margin-bottom: 32px;
        }
        
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 32px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .contact-item-icon {
            font-size: 24px;
            color: var(--liquid-lava);
        }
        
        .contact-item-text {
            color: var(--snow);
        }
        
        .contact-social {
            display: flex;
            gap: 16px;
        }
        
        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: var(--gluon-grey);
            color: var(--snow);
            border-radius: 50%;
            transition: var(--transition);
        }
        
        .social-link:hover {
            background-color: var(--liquid-lava);
            transform: translateY(-3px);
        }
        
        .contact-form {
            background-color: var(--snow);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        
        .form-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 24px;
            color: var(--dark-void);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--slate-grey);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            transition: var(--transition);
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--liquid-lava);
            box-shadow: 0 0 0 3px rgba(245, 142, 15, 0.2);
        }
        
        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }
        
        .form-submit {
            display: inline-block;
            padding: 12px 32px;
            background: var(--gradient-primary);
            color: var(--snow);
            border: none;
            border-radius: 50px;
            font-weight: 500;
            font-size: 16px;
            cursor: pointer;
            transition: var(--transition);
            font-family: 'Poppins', sans-serif;
        }
        
        .form-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(245, 142, 15, 0.3);
        }
        
        /* Footer */
        footer {
            padding: 48px 0;
            background-color: var(--gluon-grey);
            color: var(--dusty-grey);
            text-align: center;
        }
        
        .footer-text {
            margin-bottom: 24px;
        }
        
        .footer-text a {
            color: var(--liquid-lava);
            text-decoration: none;
        }
        
        .footer-text a:hover {
            text-decoration: underline;
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .hero-grid, 
            .about-grid, 
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 48px;
            }
            
            .hero-content {
                padding-right: 0;
                text-align: center;
            }
            
            .hero-description {
                margin-left: auto;
                margin-right: auto;
            }
            
            .hero-title {
                font-size: 48px;
            }
            
            .section-title {
                font-size: 36px;
            }
            
            .section-subtitle {
                margin-left: auto;
                margin-right: auto;
            }
            
            .projects-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero-title {
                font-size: 36px;
            }
            
            .section-title {
                font-size: 30px;
            }
            
            .timeline {
                padding-left: 30px;
            }
            
            .timeline-item::before {
                left: -41px;
            }
            
            .contact-form {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <nav id="navbar">
        <div class="container nav-container">
            <a href="#" class="logo"><?= htmlspecialchars($user['username']) ?></a>
            
            <div class="nav-links">
                <a href="#about">About</a>
                <?php if ($education): ?>
                <a href="#education">Education</a>
                <?php endif; ?>
                <?php if (!empty($projects)): ?>
                <a href="#projects">Projects</a>
                <?php endif; ?>
                <a href="#contact">Contact</a>
            </div>
        </div>
    </nav>
    
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <div class="hero-subtitle">Hello, I'm</div>
                    <h1 class="hero-title"><?= htmlspecialchars($user['username']) ?> <span>.</span></h1>
                    
                    <p class="hero-description">
                        <?php if ($profile['title']): ?>
                            <?= htmlspecialchars($profile['title']) ?>
                        <?php else: ?>
                            A creative professional passionate about designing and building innovative solutions.
                        <?php endif; ?>
                    </p>
                    
                    <a href="#contact" class="hero-cta">Get in Touch</a>
                </div>
                
                <div class="hero-image">
                    <div class="profile-image">
                        <?= strtoupper(substr($user['username'], 0, 1)) ?>
                    </div>
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="about" id="about">
        <div class="container">
            <h2 class="section-title">About <span>Me</span></h2>
            <p class="section-subtitle">
                <?php if ($profile['title']): ?>
                    <?= htmlspecialchars($profile['title']) ?>
                <?php else: ?>
                    Here you'll find more information about me, what I do, and my current skills
                <?php endif; ?>
            </p>
            
            <div class="about-grid">
                <div class="about-image">
                    <div class="about-img">About Me</div>
                </div>
                
                <div class="about-content">
                    <?php if ($profile['bio']): ?>
                        <p><?= nl2br(htmlspecialchars($profile['bio'])) ?></p>
                    <?php else: ?>
                        <p>
                            I'm a passionate, self-proclaimed designer who specializes in creating exceptional digital experiences. 
                            Currently, I'm focused on building accessible, human-centered products at my company.
                        </p>
                        <p>
                            My interest in design started back in college when I was asked to design a poster for a local event. 
                            Since then, I've been on a journey to learn and grow in the creative field.
                        </p>
                    <?php endif; ?>
                    
                    <div class="about-stats">
                        <div class="stat-item">
                            <div class="stat-number">3+</div>
                            <div class="stat-label">Years Experience</div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-number">10+</div>
                            <div class="stat-label">Projects</div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-number">5+</div>
                            <div class="stat-label">Happy Clients</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php if ($education): ?>
    <section class="education" id="education">
        <div class="container">
            <h2 class="section-title">My <span>Education</span></h2>
            <p class="section-subtitle">
                My academic background and qualifications
            </p>
            
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-date">
                        <?= $education['start_date'] ? date('Y', strtotime($education['start_date'])) : '' ?> - 
                        <?= $education['end_date'] ? date('Y', strtotime($education['end_date'])) : 'Present' ?>
                    </div>
                    <h3 class="timeline-title"><?= htmlspecialchars($education['institution']) ?></h3>
                    
                    <?php if ($education['degree'] && $education['field']): ?>
                    <div class="timeline-subtitle"><?= htmlspecialchars($education['degree']) ?> in <?= htmlspecialchars($education['field']) ?></div>
                    <?php endif; ?>
                    
                    <div class="timeline-content">
                        <p>
                            Studied various subjects including design principles, user experience, 
                            and development methodologies, gaining a strong foundation for my career.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <?php if (!empty($projects)): ?>
    <section class="projects" id="projects">
        <div class="container">
            <h2 class="section-title">My <span>Projects</span></h2>
            <p class="section-subtitle">
                Here are some of my recent works
            </p>
            
            <div class="projects-grid">
                <?php foreach ($projects as $project): ?>
                <div class="project-card">
                    <div class="project-image">
                        <?= htmlspecialchars($project['title']) ?>
                        <div class="project-overlay">
                            <h3 class="project-overlay-title"><?= htmlspecialchars($project['title']) ?></h3>
                            <div class="project-category">Development</div>
                        </div>
                    </div>
                    
                    <div class="project-content">
                        <h3 class="project-title"><?= htmlspecialchars($project['title']) ?></h3>
                        
                        <?php if ($project['description']): ?>
                        <p class="project-description"><?= htmlspecialchars($project['description']) ?></p>
                        <?php endif; ?>
                        
                        <?php if ($project['github_link']): ?>
                        <a href="<?= htmlspecialchars($project['github_link']) ?>" class="project-link" target="_blank">View on GitHub →</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <section class="contact" id="contact">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-content">
                    <h2 class="contact-title">Get In <span>Touch</span></h2>
                    <p class="contact-text">
                        Feel free to contact me for any project or collaboration.
                    </p>
                    
                    <div class="contact-info">
                        <div class="contact-item">
                            <div class="contact-item-icon">📧</div>
                            <div class="contact-item-text"><?= htmlspecialchars($user['email']) ?></div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-item-icon">🌐</div>
                            <div class="contact-item-text">
                                <?php if (isset($social_links['portfolio'])): ?>
                                    <?= htmlspecialchars($social_links['portfolio']) ?>
                                <?php else: ?>
                                    <?= htmlspecialchars($user['username']) ?>.portfolio
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php if (isset($social_links['leetcode'])): ?>
                        <div class="contact-item">
                            <div class="contact-item-icon">💻</div>
                            <div class="contact-item-text"><?= htmlspecialchars($social_links['leetcode']) ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="contact-social">
                        <a href="#" class="social-link">G</a>
                        <a href="#" class="social-link">L</a>
                        <a href="#" class="social-link">T</a>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h3 class="form-title">Send Me a Message</h3>
                    
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Your Name">
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Your Email">
                        </div>
                        
                        <div class="form-group">
                            <label for="message" class="form-label">Message</label>
                            <textarea id="message" name="message" class="form-control" placeholder="Your Message"></textarea>
                        </div>
                        
                        <button type="submit" class="form-submit">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="container">
            <p class="footer-text">
                &copy; <?= date('Y') ?> <?= htmlspecialchars($user['username']) ?> | Created with <a href="https://propile.example.com" target="_blank">ProPile</a>
            </p>
        </div>
    </footer>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Animation on scroll
        const animateElements = document.querySelectorAll('.hero-content, .about-grid, .timeline-item, .project-card, .contact-content, .contact-form');
        
        function checkIfInView() {
            animateElements.forEach(element => {
                const rect = element.getBoundingClientRect();
                const windowHeight = window.innerHeight || document.documentElement.clientHeight;
                
                if (rect.top <= windowHeight * 0.75 && rect.bottom >= 0) {
                    element.style.opacity = 1;
                    element.style.transform = 'translateY(0)';
                }
            });
        }
        
        // Set initial styles
        animateElements.forEach(element => {
            element.style.opacity = 0;
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
        });
        
        // Check elements on load
        window.addEventListener('DOMContentLoaded', checkIfInView);
        
        // Check elements on scroll
        window.addEventListener('scroll', checkIfInView);
    </script>
</body>
</html>