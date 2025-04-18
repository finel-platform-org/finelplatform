<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Admin Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Base Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #2d3748;
        }

        /* Container Styles */
        .register-container {
            position: relative;
            width: 100%;
            max-width: 500px;
            margin: 2rem;
            padding: 2.5rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            z-index: 1;
        }

        /* Background Shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.1;
            z-index: -1;
        }
        .shape-1 {
            width: 300px;
            height: 300px;
            background: #6a11cb;
            top: -50px;
            left: -50px;
            animation: float 8s ease-in-out infinite;
        }
        .shape-2 {
            width: 200px;
            height: 200px;
            background: #2575fc;
            bottom: -30px;
            right: -30px;
            animation: float 6s ease-in-out infinite reverse;
        }
        .shape-3 {
            width: 150px;
            height: 150px;
            background: #00f2fe;
            top: 40%;
            left: 60%;
            animation: float 10s ease-in-out infinite 2s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* Header Styles */
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .register-header h2 {
            font-size: 1.8rem;
            color: #2d3748;
            margin-bottom: 0.5rem;
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .register-header p {
            color: #718096;
        }

        /* Form Styles */
        .register-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        /* Input Groups */
        .input-group {
            position: relative;
        }
        .input-group input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
            background-color: #f8fafc;
        }
        .input-group input:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 0 3px rgba(106, 17, 203, 0.2);
            outline: none;
            background-color: white;
        }
        .input-group label {
            position: absolute;
            left: 3rem;
            top: 1rem;
            color: #718096;
            transition: all 0.3s;
            pointer-events: none;
        }
        .input-group input:focus + label,
        .input-group input:not(:placeholder-shown) + label {
            top: -0.5rem;
            left: 3rem;
            font-size: 0.75rem;
            background: white;
            padding: 0 0.5rem;
            color: #6a11cb;
        }
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
        }
        .input-group input:focus ~ .input-icon {
            color: #6a11cb;
        }

        /* Error Messages */
        .error-message {
            color: #e53e3e;
            font-size: 0.75rem;
            margin-top: 0.5rem;
        }

        /* Terms Checkbox */
        .terms-group {
            display: flex;
            align-items: center;
            margin: 1rem 0;
        }
        .terms-group input {
            margin-right: 10px;
            accent-color: #6a11cb;
        }
        .terms-group label {
            font-size: 0.9rem;
            color: #4a5568;
        }
        .terms-link {
            color: #6a11cb;
            text-decoration: none;
            font-weight: 500;
        }
        .terms-link:hover {
            text-decoration: underline;
        }

        /* Register Button */
        .register-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 1rem;
            border-radius: 10px;
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            color: white;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(106, 17, 203, 0.2);
        }
        .register-btn i {
            transition: transform 0.3s;
        }
        .register-btn:hover i {
            transform: translateX(5px);
        }

        /* Login Link */
        .login-link {
            text-align: center;
            color: #718096;
            font-size: 0.9rem;
        }
        .login-link a {
            color: #6a11cb;
            text-decoration: none;
            font-weight: 500;
        }
        .login-link a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .register-container {
                margin: 1rem;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Animated Background Shapes -->
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>

        <!-- Header -->
        <div class="register-header">
            <h2>Créer Votre Compte            </h2>
        </div>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}" class="register-form">
            @csrf

            <!-- Name Field -->
            <div class="input-group floating">
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder=" ">
                <label for="name">Nom</label>
                <i class="fas fa-user input-icon"></i>
                @if($errors->has('name'))
                    <div class="error-message">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <!-- Email Field -->
            <div class="input-group floating">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder=" ">
                <label for="email">Email</label>
                <i class="fas fa-envelope input-icon"></i>
                @if($errors->has('email'))
                    <div class="error-message">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <!-- Password Field -->
            <div class="input-group floating">
                <input id="password" type="password" name="password" required placeholder=" ">
                <label for="password">Mot de passe</label>
                <i class="fas fa-lock input-icon"></i>
                @if($errors->has('password'))
                    <div class="error-message">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <!-- Confirm Password Field -->
            <div class="input-group floating">
                <input id="password_confirmation" type="password" name="password_confirmation" required placeholder=" ">
                <label for="password_confirmation">Confirmer mot de passe</label>
                <i class="fas fa-lock input-icon"></i>
            </div>

            <!-- Terms Checkbox -->
            <div class="terms-group">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">
                J'accepte les<a href="#" class="terms-link">Conditions de Service</a> et 
                    <a href="#" class="terms-link">Privacy Policy</a>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="register-btn">
                <span>créer le compte</span>
                <i class="fas fa-arrow-right"></i>
            </button>

            <!-- Login Link -->
            <div class="login-link">
            Vous avez déjà un compte? 
                <a href="{{ route('login') }}">Se connecter</a>
            </div>
        </form>
    </div>

    <script>
        // Simple password strength indicator
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            // You can add more sophisticated strength checking here
        });
    </script>
</body>
</html>