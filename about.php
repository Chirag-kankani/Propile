<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - ProPile</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <style>
        .about-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--dark-void) 0%, var(--gluon-grey) 100%);
            color: var(--snow);
            padding: var(--spacing-6);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--spacing-4);
            margin-top: var(--spacing-5);
        }

        .team-member {
            background-color: rgba(251, 251, 251, 0.05);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-4);
            text-align: center;
            transition: var(--transition-medium);
            border: 2px solid #F56E0F;
        }

        .team-member:hover {
            transform: translateY(-5px);
            background-color: rgba(251, 251, 251, 0.1);
            border: 2px solid #F56E0F;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px #F56E0F, 0 0 20px #F56E0F, 0 0 30px #F56E0F;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .member-avatar {
            width: 120px;
            height: 120px;
            background-color: var(--liquid-lava);
            border-radius: 50%;
            margin: 0 auto var(--spacing-3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: var(--snow);
        }

        .member-name {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: var(--spacing-1);
        }

        .member-role {
            color: var(--liquid-lava);
            font-size: 0.9rem;
            margin-bottom: var(--spacing-2);
        }

        .member-bio {
            color: var(--dusty-grey);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .back-link {
            display: inline-block;
            color: #F56E0F;
            text-decoration: none;
            margin-bottom: var(--spacing-4);
            font-weight: 500;
            transition: var(--transition-fast);
        }

        .back-link:hover {
            transform: translateY(-5px);
            color: #F56E0F;
        }

        .tagline {
            color: #F56E0F;
        }
    </style>
</head>

<body>
    <div class="about-container">
        <div class="container">
            <a href="index.php" class="back-link">← Back to Home</a>
            <h1 class="main-heading">About Us</h1>
            <p class="tagline">Meet the team behind ProPile</p>

            <div class="team-grid">
                <div class="team-member">
                    <div class="member-avatar">S</div>
                    <h2 class="member-name">Shivaprasad Basavaraj Gowda</h2>
                    <p class="member-role">AI-ML Developer</p>
                    <p class="member-bio">
                        AI-ML developer with expertise in Artificial Intelligence and Machine Learning.
                    </p>
                </div>

                <div class="team-member">
                    <div class="member-avatar">C</div>
                    <h2 class="member-name">Chirag Kankani</h2>
                    <p class="member-role">Web Developer and UI/UX Designer</p>
                    <p class="member-bio">
                        Specializes in creating beautiful and responsive user interfaces.
                    </p>
                </div>

                <div class="team-member">
                    <div class="member-avatar">Y</div>
                    <h2 class="member-name">Yash Verdhan</h2>
                    <p class="member-role">Backend Developer</p>
                    <p class="member-bio">
                        Expert in database design and server-side architecture.
                    </p>
                </div>

                <div class="team-member">
                    <div class="member-avatar">K</div>
                    <h2 class="member-name">Kartik</h2>
                    <p class="member-role">UI/UX Designer</p>
                    <p class="member-bio">
                        Creates intuitive and engaging user experiences.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>

</html>