<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - ProPile</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <style>
        .contact-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--dark-void) 0%, var(--gluon-grey) 100%);
            color: var(--snow);
            padding: var(--spacing-6);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--spacing-4);
            margin-top: var(--spacing-5);
        }

        .contact-info {
            background-color: rgba(251, 251, 251, 0.05);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-4);
            border: 2px solid #F56E0F;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 5px #F56E0F, 0 0 10px #F56E0F;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .contact-form {
            background-color: rgba(251, 251, 251, 0.05);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-4);
        }

        .info-item {
            display: flex;
            /* align-items: center; */
            gap: var(--spacing-3);
            margin-bottom: var(--spacing-3);
            padding: var(--spacing-3);
            background-color: rgba(251, 251, 251, 0.05);
            border-radius: var(--border-radius-md);
            transition: var(--transition-fast);
        }

        .info-item:hover {
            background-color: rgba(251, 251, 251, 0.1);
            transform: translateX(5px);
            border-color: #F56E0F;
        }

        .info-icon {
            font-size: 24px;
            color: var(--liquid-lava);
            width: 48px;
            height: 48px;
            background-color: rgba(245, 142, 15, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-content h3 {
            font-size: 1.1rem;
            margin-bottom: 4px;
        }

        .info-content p {
            color: var(--dusty-grey);
        }

        .back-link {
            display: inline-block;
            color: var(--liquid-lava);
            text-decoration: none;
            margin-bottom: var(--spacing-4);
            font-weight: 500;
            transition: var(--transition-fast);
        }

        .back-link:hover {
            color: #e07c00;
            transform: translateY(-5px);
        }

        .contact-form {
            border: 2px solid #F56E0F;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 0 5px #F56E0F, 0 0 10px #F56E0F;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .contact-form form {
            display: grid;
            gap: var(--spacing-3);
        }

        .form-group {
            display: grid;
            gap: 8px;
        }

        .form-label {
            color: var(--snow);
            font-size: 0.9rem;
        }

        .form-input,
        .form-textarea {
            padding: 12px;
            background-color: rgba(251, 251, 251, 0.05);
            border: 1px solid rgba(251, 251, 251, 0.1);
            border-radius: var(--border-radius-sm);
            color: var(--snow);
            transition: var(--transition-fast);
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--liquid-lava);
            background-color: rgba(251, 251, 251, 0.1);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .submit-btn {
            background-color: #F56E0F;
            color: var(--snow);
            border: none;
            padding: 12px 24px;
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition-fast);
        }

        .submit-btn:hover {
            background-color: #F56E0F;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="contact-container">
        <div class="container">
            <a href="index.php" class="back-link">← Back to Home</a>
            <h1 class="main-heading">Contact Us</h1>
            <p class="tagline">Get in touch with our team</p>

            <div class="contact-grid">
                <div class="contact-info">
                    <div class="info-item">
                        <div class="info-icon">🙋‍♂️</div>
                        <div class="info-content">
                            <h3>Name</h3>
                            <p>Propile Team</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">📞</div>
                        <div class="info-content">
                            <h3>Phone</h3>
                            <p>99xxxxxx</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">📧</div>
                        <div class="info-content">
                            <h3>Email</h3>
                            <p>propile@gmail.com</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">📍</div>
                        <div class="info-content">
                            <h3>Office Hours</h3>
                            <p>Monday - Friday, 9:00 AM - 6:00 PM</p>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <form id="contactForm">
                        <div class="form-group">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" id="name" name="name" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" id="email" name="email" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" id="subject" name="subject" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label for="message" class="form-label">Message</label>
                            <textarea id="message" name="message" class="form-textarea" required></textarea>
                        </div>

                        <button type="submit" class="submit-btn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Thank you for your message! We will get back to you soon.');
            this.reset();
        });
    </script>
</body>
</html>