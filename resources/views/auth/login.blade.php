<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Portal</title>
    <style>
        /* Base Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(-45deg, #6a11cb, #2575fc, #4facfe, #00f2fe);
            background-size: 400% 400%;
            animation: gradientBG 12s ease infinite;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Login Container */
        .login-container {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin: 20px;
        }

        /* Logo Styles */
        .logo {
            margin-bottom: 30px;
        }

        .logo img {
            width: 80px;
            height: auto;
        }

        .logo h1 {
            margin: 10px 0 0;
            font-size: 28px;
            background: linear-gradient(90deg, white, #e0e0e0);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .input-field {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 16px;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        .input-field:focus {
            outline: none;
            border-color: white;
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
        }

        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Button Styles */
        .login-btn {
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            background: white;
            color: #6a11cb;
            font-weight: 600;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Link Styles */
        .links {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .links a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
        }

        .links a:hover {
            text-decoration: underline;
        }

        /* Message Styles */
        .error-message {
            color: #ff6b6b;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .status-message {
            color: #4ade80;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        /* Remember Me Checkbox */
        .form-group input[type="checkbox"] {
            accent-color: #6a11cb;
        }

        /* Responsive Styles */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
            
            .logo img {
                width: 60px;
            }
            
            .logo h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo du Portail Admin">
            <h1>Portail Admin</h1>
        </div>

        @if($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Adresse e-mail</label>
                <input type="email" id="email" name="email" class="input-field" 
                       value="{{ old('email') }}" required autofocus placeholder="Entrez votre e-mail">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" class="input-field" 
                       required placeholder="Entrez votre mot de passe">
            </div>

            <div class="form-group" style="text-align: left; margin: 15px 0;">
                <input type="checkbox" id="remember" name="remember" style="margin-right: 8px;">
                <label for="remember" style="display: inline; font-weight: normal;">Se souvenir de moi</label>
            </div>

            <button type="submit" class="login-btn">Se connecter</button>

         <!--  <div class="links">
              @if (Route::has('register'))
                    <a href="{{ route('register') }}">Créer un compte</a>
                @endif
                
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                @endif
            </div>-->
        </form>
    </div>
</body>

</html>