<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
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
            <p>Login to explore</p>
            <div class="dots">● ● ● ●</div>
        </div>
    </div>

    <div class="right-panel">
        <div class="form-wrap">
            <h1>Login your account!</h1>

            <div class="method-tabs" role="tablist">
                <button class="tab active" data-target="email" role="tab">E-mail</button>
            </div>

            <form id="loginForm" action="{{ url('/login') }}" method="POST">
                @csrf
                @if($errors->any())
                    <div class="errors" style="margin-bottom:12px;color:#c00;font-size:13px">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <input type="hidden" name="method" id="method" value="email">

                <div class="field" data-for="email">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" placeholder="Email" value="{{ old('email') }}">
                    @error('email')<div class="error" style="color:#c00;font-size:13px">{{ $message }}</div>@enderror
                </div>

                <div class="field" data-for="password">
                    <label for="password">Password</label>
                    <div class="password-wrap">
                        <input id="password" name="password" type="password" placeholder="Password">
                        <button type="button" class="show-pass" aria-label="Show password">👁</button>
                    </div>
                    @error('password')<div class="error" style="color:#c00;font-size:13px">{{ $message }}</div>@enderror
                </div>

                <div class="forgot">Forgot password?</div>

                <button type="submit" class="btn-primary">LOGIN</button>
            </form>

            <div id="socialTrigger" class="divider" role="button" aria-label="Open sign in options" tabindex="0">Sign in With</div>
            <div class="socials">
                <a class="social" href="#" aria-label="Facebook"><img src="/images/facebook-logo-facebook-social-media-icon-free-png.png" alt="Facebook"></a>
                <a class="social" href="#" aria-label="Google"><img src="/images/icons8-google-48.png" alt="Google"></a>
                <a class="social" href="#" aria-label="Apple"><img src="/images/icons8-apple-inc-24.png" alt="Apple"></a>
            </div>

            <div id="socialModal" class="social-modal" aria-hidden="true">
                <div id="socialOverlay" class="social-modal__backdrop"></div>
                <div class="social-modal__panel" role="dialog" aria-modal="true" aria-labelledby="socialModalTitle">
                    <button type="button" id="socialClose" class="social-modal__close" aria-label="Close popup">×</button>
                    <h2 id="socialModalTitle">Login using</h2>
                    <p class="social-modal__text">Choose a provider to continue.</p>
                    <div class="social-modal__buttons">
                        <a href="#" class="social-modal__button social-modal__button--facebook">Facebook</a>
                        <a href="#" class="social-modal__button social-modal__button--google">Google</a>
                        <a href="#" class="social-modal__button social-modal__button--apple">Apple</a>
                    </div>
                </div>
            </div>

            <p class="signup">Dont have an account? <a href="/register">Sign up</a></p>
        </div>
    </div>
</div>

<script src="/js/login.js"></script>
</body>
</html>