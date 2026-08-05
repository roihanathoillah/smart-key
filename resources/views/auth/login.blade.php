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
                <button class="tab" data-target="mobile" role="tab">Mobile Number</button>
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

                <div class="field" data-for="mobile" style="display:none;">
                    <label for="mobile">Mobile Number</label>
                    <input id="mobile" name="mobile" type="tel" placeholder="0812xxxxxxx" value="{{ old('mobile') }}">
                    @error('mobile')<div class="error" style="color:#c00;font-size:13px">{{ $message }}</div>@enderror
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

                <button type="submit" class="btn-primary">Continue</button>
            </form>

            <div class="divider">Sign in With</div>
            <div class="socials">
                <a class="social" href="#" aria-label="Facebook">f</a>
                <a class="social" href="#" aria-label="Google">G</a>
                <a class="social" href="#" aria-label="Apple"></a>
            </div>

            <p class="signup">Dont have an account? <a href="/register">Sign up</a></p>
        </div>
    </div>
</div>

<script src="/js/login.js"></script>
</body>
</html>
