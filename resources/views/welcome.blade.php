<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Custom CSS */
        .welcome-hero {
            background: linear-gradient(-45deg, #6a11cb, #2575fc, #4facfe, #00f2fe);
            background-size: 400% 400%;
            animation: gradientBG 12s ease infinite;
            min-height: 100vh;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .auth-buttons .btn {
            min-width: 120px;
            transition: all 0.3s;
        }
        
        [data-bs-theme="dark"] .welcome-hero {
            background: linear-gradient(-45deg, #1e1b4b, #312e81, #4338ca, #4f46e5);
        }
        /* Features Section */
        .features-section {
            padding: 5rem 2rem;
            background: white;
            position: relative;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .section-header p {
            font-size: 1.2rem;
            color: #718096;
            max-width: 700px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: #f8fafc;
            border-radius: 15px;
            padding: 2rem;
            transition: all 0.3s;
            border: 1px solid #e2e8f0;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: #6a11cb;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #2d3748;
        }

        .feature-card p {
            color: #718096;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <!-- Welcome Section -->
    <section class="welcome-hero d-flex align-items-center">
        <div class="container text-center text-white py-5">
            <!-- Auth Buttons (Top-Right) -->
            <div class="auth-buttons position-absolute top-0 end-0 mt-3 me-3">
                <a href="/login" class="btn btn-outline-light me-2">
                    <i class="fas fa-sign-in-alt me-1"></i> Se Connecter
                </a>
                
            </div>
            
            <div class="floating mb-4">
                <i class="fas fa-chart-line fa-4x mb-3"></i>
                <h1 class="display-3 fw-bold mb-3">Bienvenue à <span class="text-warning">PlanUni</span></h1>
            </div>
            
            <p class="lead mb-5 mx-auto" style="max-width: 700px;">
            Gérez les cours, les professeurs et les salles de votre établissement avec notre tableau de bord intuitif.
            </p>
            
            <!-- CTA Buttons -->
            <div class="d-flex justify-content-center gap-3">
                <a href="#dashboard" class="btn btn-light btn-lg px-4 py-2 rounded-pill">
                    <i class="fas fa-tachometer-alt me-2"></i> explorer le tableau de bord
                </a>
                
            </div>
        </div>
    </section>
    <section class="features-section">
    <div class="features-container">
        <div class="section-header">
            <h2>Fonctionnalités puissantes</h2>
            <p>Notre plateforme vous offre tout ce dont vous avez besoin pour gérer efficacement votre établissement éducatif.</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Gestion des utilisateurs</h3>
                <p>Gérez facilement les professeurs, étudiants et administrateurs grâce à notre interface intuitive et un système d'accès basé sur les rôles.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3>Planification</h3>
                <p>Créez et gérez les emplois du temps avec une fonctionnalité de glisser-déposer et une détection automatique des conflits.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Analytique</h3>
                <p>Obtenez des informations précieuses grâce aux analyses en temps réel et aux rapports personnalisables sur la présence, la performance, et plus encore.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h3>Gestion des salles</h3>
                <p>Optimisez l'utilisation des espaces grâce à notre système intelligent d'allocation des salles et de suivi des disponibilités.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <h3>Notifications</h3>
                <p>Gardez tout le monde informé grâce aux notifications automatiques pour les changements de planning, les annonces et les échéances.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Compatible mobile</h3>
                <p>Accédez à toutes les fonctionnalités en déplacement grâce à notre design entièrement réactif, compatible avec tous les appareils.</p>
            </div>
        </div>
    </div>
</section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>