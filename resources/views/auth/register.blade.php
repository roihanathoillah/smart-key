<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create account</title>
    <link rel="stylesheet" href="/css/login.css">
</head>
<body>
<div class="login-root">
    <div class="left-panel">
        <div class="brand-image">
            <img src="/images/1000452284.png" alt="Smart Key Logo">
        </div>
        <div class="hero-art" aria-hidden="true"></div>
        <div class="welcome-card">
            <h3>Welcome to the community</h3>
            <p>sign up to explore</p>
            <div class="dots">● ● ● ●</div>
        </div>
    </div>

    <div class="right-panel">
        <div class="form-wrap">
            <h1>Create your account!</h1>
            <p style="font-size:13px;font-weight:700;margin-bottom:10px">Enter your Full Details</p>

            <form id="registerForm" action="{{ url('/register') }}" method="POST">
                @csrf
                @if($errors->any())
                    <div class="errors" style="margin-bottom:12px;color:#c00;font-size:13px">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="field">
                    <label for="name">Username</label>
                    <input id="name" name="name" type="text" placeholder="Username" value="{{ old('name') }}">
                    @error('name')<div class="error" style="color:#c00;font-size:13px">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" placeholder="Email" value="{{ old('email') }}">
                    @error('email')<div class="error" style="color:#c00;font-size:13px">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="password-wrap">
                        <input id="password" name="password" type="password" placeholder="Password">
                        <button type="button" class="show-pass" aria-label="Show password">👁</button>
                    </div>
                    @error('password')<div class="error" style="color:#c00;font-size:13px">{{ $message }}</div>@enderror
                </div>

                <div style="margin:12px 0"><label><input type="checkbox" name="remember"> Remember me</label></div>

                <button type="submit" class="btn-primary">Continue</button>
            </form>

            <div class="divider">Sign in With</div>
            <div class="socials">
                <a class="social" href="#" aria-label="Facebook"><img src="/images/facebook-logo-facebook-social-media-icon-free-png.png" alt="Facebook"></a>
                <a class="social" href="#" aria-label="Google"><img src="/images/icons8-google-48.png" alt="Google"></a>
                <a class="social" href="#" aria-label="Apple"><img src="/images/icons8-apple-inc-24.png" alt="Apple"></a>
            </div>

            <p class="signup">Already have an account? <a href="/login">Sign in</a></p>
        </div>
    </div>
</div>

<script src="/js/register.js"></script>
</body>
</html>
