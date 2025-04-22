<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $user['username'] ?>'s Developer Portfolio - ProPile</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap">
    <style>
        :root {
            --dark-void: #151419;
            --liquid-lava: #F58E0F;
            --gluon-grey: #1B1B1E;
            --slate-grey: #262626;
            --dusty-grey: #878787;
            --snow: #FBFBFB;
            
            --font-sans: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            --font-mono: 'Fira Code', monospace;
            --transition: all 0.2s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: var(--font-sans);
            color: var(--dark-void);
            background-color: var(--dark-void);
            line-height: 1.5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }
        
        /* Header / Hero */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 80px 0;
            color: var(--snow);
        }
        
        .hero-content {
            max-width: 800px;
        }
        
        .hero-greeting {
            font-family: var(--font-mono);
            color: var(--liquid-lava);
            margin-bottom: 16px;
        }
        
        .hero-name {
            font-size: 72px;
            font-weight: 700;
            margin-bottom: 16px;
            line-height: 1.1;
        }
        
        .hero-subtitle {
            font-size: 40px;
            color: var(--dusty-grey);
            margin-bottom: 24px;
        }
        
        .hero-description {
            font-size: 18px;
            color: var(--dusty-grey);
            margin-bottom: 32px;
            max-width: 500px;
        }
        
        .hero-cta {
            display: inline-block;
            background-color: var(--liquid-lava);
            color: var(--snow);
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .hero-cta:hover {
            background-color: #e07c00;
            transform: translateY(-2px);
        }
        
        .social-links {
            display: flex;
            gap: 16px;
            margin-top: 32px;
        }
        
        .social-link {
            color: var(--dusty-grey);
            text-decoration: none;
            transition: var(--transition);
        }
        
        .social-link:hover {
            color: var(--liquid-lava);
        }
        
        /* About */
        .about {
            padding: 100px 0;
            background-color: var(--gluon-grey);
            color: var(--snow);
        }
        
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            align-items: center;
        }
        
        .about-image {
            width: 100%;
            aspect-ratio: 1;
            background-color: var(--slate-grey);
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 96px;
            color: var(--snow);
        }
        
        .section-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 24px;
            color: var(--snow);
        }
        
        .section-title span {
            color: var(--liquid-lava);
        }
        
        .about-content p {
            margin-bottom: 16px;
            color: var(--dusty-grey);
        }
        
        /* Skills */
        .skills {
            padding: 100px 0;
            background-color: var(--dark-void);
            color: var(--snow);
        }
        
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 24px;
            margin-top: 40px;
        }
        
        .skill-category {
            background-color: var(--gluon-grey);
            padding: 24px;
            border-radius: 8px;
        }
        
        .skill-category h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 16px;
            color: var(--liquid-lava);
        }
        
        .skills-list {
            list-style: none;
        }
        
        .skills-list li {
            font-family: var(--font-mono);
            margin-bottom: 8px;
            color: var(--dusty-grey);
        }
        
        .skills-list li::before {
            content: '▹';
            color: var(--liquid-lava);
            margin-right: 8px;
        }
        
        /* Projects */
        .projects {
            padding: 100px 0;
            background-color: var(--gluon-grey);
            color: var(--snow);
        }
        
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 32px;
            margin-top: 40px;
        }
        
        .project-card {
            background-color: var(--dark-void);
            border-radius: 8px;
            overflow: hidden;
            transition: var(--transition);
        }
        
        .project-card:hover {
            transform: translateY(-5px);
        }
        
        .project-img {
            width: 100%;
            height: 200px;
            background-color: var(--slate-grey);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-mono);
            color: var(--snow);
        }
        
        .project-content {
            padding: 24px;
        }
        
        .project-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 12px;
            color: var(--snow);
        }
        
        .project-desc {
            font-size: 16px;
            color: var(--dusty-grey);
            margin-bottom: 20px;
        }
        
        .project-tech {
            font-family: var(--font-mono);
            font-size: 14px;
            color: var(--liquid-lava);
            margin-bottom: 16px;
        }
        
        .project-links {
            display: flex;
            gap: 16px;
        }
        
        .project-link {
            color: var(--snow);
            text-decoration: none;
            transition: var(--transition);
        }
        
        .project-link:hover {
            color: var(--liquid-lava);
        }
        
        /* Education */
        .education {
            padding: 100px 0;
            background-color: var(--dark-void);
            color: var(--snow);
        }
        
        .education-item {
            background-color: var(--gluon-grey);
            padding: 32px;
            border-radius: 8px;
            margin-top: 40px;
        }
        
        .education-school {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--snow);
        }
        
        .education-degree {
            font-size: 18px;
            color: var(--liquid-lava);
            margin-bottom: 16px;
        }
        
        .education-dates {
            font-family: var(--font-mono);
            font-size: 16px;
            color: var(--dusty-grey);
        }
        
        /* Contact */
        .contact {
            padding: 100px 0;
            text-align: center;
            background-color: var(--gluon-grey);
            color: var(--snow);
        }
        
        .contact-content {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .contact-title {
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 16px;
        }
        
        .contact-subtitle {
            font-size: 18px;
            color: var(--dusty-grey);
            margin-bottom: 32px;
        }
        
        .contact-button {
            display: inline-block;
            background-color: transparent;
            color: var(--liquid-lava);
            text-decoration: none;
            padding: 12px 48px;
            border: 1px solid var(--liquid-lava);
            border-radius: 4px;
            font-family: var(--font-mono);
            font-size: 16px;
            transition: var(--transition);
        }
        
        .contact-button:hover {
            background-color: rgba(245, 142, 15, 0.1);
            transform: translateY(-2px);
        }
        
        /* Footer */
        footer {
            padding: 32px 0;
            background-color: var(--dark-void);
            color: var(--dusty-grey);
            text-align: center;
            font-size: 14px;
        }
        
        .footer-text a {
            color: var(--liquid-lava);
            text-decoration: none;
        }
        
        .footer-text a:hover {
            text-decoration: underline;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-name {
                font-size: 48px;
            }
            
            .hero-subtitle {
                font-size: 28px;
            }
            
            .about-grid {
                grid-template-columns: 1fr;
            }
            
            .projects-grid {
                grid-template-columns: 1fr;
            }
            
            .section-title {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <p class="hero-greeting">Hello, my name is</p>
                <h1 class="hero-name"><?= htmlspecialchars($user['username']) ?></h1>
                <h2 class="hero-subtitle"><?= $profile['title'] ? htmlspecialchars($profile['title']) : 'I build things for the web' ?></h2>
                
                <p class="hero-description">
                    <?php if ($profile['bio']): ?>
                        <?= nl2br(htmlspecialchars($profile['bio'])) ?>
                    <?php else: ?>
                        I'm a software developer specializing in building exceptional digital experiences. 
                        Currently, I'm focused on creating accessible, human-centered products.
                    <?php endif; ?>
                </p>
                
                <a href="#projects" class="hero-cta">Check out my work</a>
                
                <div class="social-links">
                    <?php if (isset($social_links['portfolio'])): ?>
                    <a href="<?= htmlspecialchars($social_links['portfolio']) ?>" class="social-link" target="_blank">Portfolio</a>
                    <?php endif; ?>
                    
                    <?php if (isset($social_links['leetcode'])): ?>
                    <a href="<?= htmlspecialchars($social_links['leetcode']) ?>" class="social-link" target="_blank">LeetCode</a>
                    <?php endif; ?>
                    
                    <a href="mailto:<?= htmlspecialchars($user['email']) ?>" class="social-link">Email</a>
                </div>
            </div>
        </div>
    </section>
    
    <section class="about" id="about">
        <div class="container">
            <div class="about-grid">
                <div class="about-image">
                    <?= strtoupper(substr($user['username'], 0, 1)) ?>
                </div>
                
                <div class="about-content">
                    <h2 class="section-title"><span>01.</span> About Me</h2>
                    
                    <?php if ($profile['bio']): ?>
                        <p><?= nl2br(htmlspecialchars($profile['bio'])) ?></p>
                    <?php else: ?>
                        <p>
                            Hello! I'm a passionate developer who enjoys creating things that live on the internet. 
                            My interest in web development started back in college when I decided to try editing 
                            custom Tumblr themes — turns out hacking together a custom reblog button taught me a lot about HTML & CSS!
                        </p>
                        <p>
                            Fast-forward to today, and I've had the privilege of working on a variety of projects. 
                            My main focus these days is building accessible, inclusive products and digital 
                            experiences for a variety of clients.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    
    <section class="skills" id="skills">
        <div class="container">
            <h2 class="section-title"><span>02.</span> Skills</h2>
            
            <div class="skills-grid">
                <div class="skill-category">
                    <h3>Languages</h3>
                    <ul class="skills-list">
                        <li>JavaScript (ES6+)</li>
                        <li>TypeScript</li>
                        <li>HTML</li>
                        <li>CSS/SCSS</li>
                        <li>Python</li>
                    </ul>
                </div>
                
                <div class="skill-category">
                    <h3>Frameworks</h3>
                    <ul class="skills-list">
                        <li>React</li>
                        <li>Vue</li>
                        <li>Node.js</li>
                        <li>Express</li>
                        <li>Next.js</li>
                    </ul>
                </div>
                
                <div class="skill-category">
                    <h3>Tools</h3>
                    <ul class="skills-list">
                        <li>Git & GitHub</li>
                        <li>VS Code</li>
                        <li>Webpack</li>
                        <li>Figma</li>
                        <li>DevTools</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <?php if (!empty($projects)): ?>
    <section class="projects" id="projects">
        <div class="container">
            <h2 class="section-title"><span>03.</span> Projects</h2>
            
            <div class="projects-grid">
                <?php foreach ($projects as $project): ?>
                <div class="project-card">
                    <div class="project-img">// <?= htmlspecialchars($project['title']) ?></div>
                    <div class="project-content">
                        <h3 class="project-title"><?= htmlspecialchars($project['title']) ?></h3>
                        
                        <?php if ($project['description']): ?>
                        <p class="project-desc"><?= htmlspecialchars($project['description']) ?></p>
                        <?php endif; ?>
                        
                        <p class="project-tech">JavaScript React Node.js</p>
                        
                        <div class="project-links">
                            <?php if ($project['github_link']): ?>
                            <a href="<?= htmlspecialchars($project['github_link']) ?>" class="project-link" target="_blank">GitHub</a>
                            <?php endif; ?>
                            
                            <?php if ($project['live_link']): ?>
                            <a href="<?= htmlspecialchars($project['live_link']) ?>" class="project-link" target="_blank">Live Demo</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <?php if ($education): ?>
    <section class="education" id="education">
        <div class="container">
            <h2 class="section-title"><span>04.</span> Education</h2>
            
            <div class="education-item">
                <h3 class="education-school"><?= htmlspecialchars($education['institution']) ?></h3>
                
                <?php if ($education['degree'] && $education['field']): ?>
                <p class="education-degree"><?= htmlspecialchars($education['degree']) ?> in <?= htmlspecialchars($education['field']) ?></p>
                <?php endif; ?>
                
                <?php if ($education['start_date'] || $education['end_date']): ?>
                <p class="education-dates">
                    <?= $education['start_date'] ? date('Y', strtotime($education['start_date'])) : '' ?> - 
                    <?= $education['end_date'] ? date('Y', strtotime($education['end_date'])) : 'Present' ?>
                </p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <section class="contact" id="contact">
        <div class="container">
            <div class="contact-content">
                <h2 class="contact-title">Get In Touch</h2>
                <p class="contact-subtitle">
                    I'm currently looking for new opportunities. Whether you have a question or just want to say hi, 
                    I'll do my best to get back to you!
                </p>
                
                <a href="mailto:<?= htmlspecialchars($user['email']) ?>" class="contact-button">Say Hello</a>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="container">
            <p class="footer-text">
                Designed & Built with <a href="https://propile.example.com" target="_blank">ProPile</a>
            </p>
        </div>
    </footer>
    
    <script>
        // Add smooth scrolling to all links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Add scroll reveal animation
        window.addEventListener('DOMContentLoaded', () => {
            const sections = document.querySelectorAll('section');
            
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };
            
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            
            sections.forEach(section => {
                section.style.opacity = 0;
                section.style.transform = 'translateY(20px)';
                section.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                observer.observe(section);
            });
        });
    </script>
</body>
</html>