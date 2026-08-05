document.addEventListener('DOMContentLoaded', function(){
    const showBtn = document.querySelector('#registerForm .show-pass') || document.querySelector('.show-pass');
    if(showBtn){
        showBtn.addEventListener('click', function(){
            const pw = document.getElementById('password');
            if(pw.type === 'password'){ pw.type = 'text'; showBtn.textContent = '🙈' }
            else { pw.type = 'password'; showBtn.textContent = '👁' }
        });
    }
});
