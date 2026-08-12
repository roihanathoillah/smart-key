document.addEventListener('DOMContentLoaded', function(){
    // Tabs
    document.querySelectorAll('.method-tabs .tab').forEach(function(btn){
        btn.addEventListener('click', function(){
            document.querySelectorAll('.method-tabs .tab').forEach(t=>t.classList.remove('active'));
            btn.classList.add('active');
            const target = btn.dataset.target;
            document.querySelectorAll('[data-for]').forEach(function(el){
                if(el.getAttribute('data-for') === target) el.style.display = '';
                else if(el.getAttribute('data-for') === 'password') el.style.display = '';
                else el.style.display = 'none';
            });
            // set hidden method field
            const methodInput = document.getElementById('method');
            if(methodInput) methodInput.value = target;
        });
    });

    // show password
    const showBtn = document.querySelector('.show-pass');
    if(showBtn){
        showBtn.addEventListener('click', function(){
            const pw = document.getElementById('password');
            if(pw.type === 'password'){ pw.type = 'text'; showBtn.textContent = '🙈' }
            else { pw.type = 'password'; showBtn.textContent = '👁' }
        });
    }
    // ensure method value corresponds to active tab on load
    const activeTab = document.querySelector('.method-tabs .tab.active');
    const methodInputOnLoad = document.getElementById('method');
    if(activeTab && methodInputOnLoad) methodInputOnLoad.value = activeTab.dataset.target || 'email';

    const socialTrigger = document.getElementById('socialTrigger');
    const socialModal = document.getElementById('socialModal');
    const socialClose = document.getElementById('socialClose');
    const socialOverlay = document.getElementById('socialOverlay');
    const socialLinks = document.querySelectorAll('.social');

    const openSocialModal = function() {
        if(!socialModal) return;
        socialModal.classList.add('active');
        socialModal.setAttribute('aria-hidden', 'false');
    };

    const closeSocialModal = function() {
        if(!socialModal) return;
        socialModal.classList.remove('active');
        socialModal.setAttribute('aria-hidden', 'true');
    };

    if(socialTrigger) {
        socialTrigger.addEventListener('click', function() {
            openSocialModal();
        });
        socialTrigger.addEventListener('keydown', function(event) {
            if(event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                openSocialModal();
            }
        });
    }

    socialLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            openSocialModal();
        });
    });

    if(socialClose) {
        socialClose.addEventListener('click', closeSocialModal);
    }

    if(socialOverlay) {
        socialOverlay.addEventListener('click', closeSocialModal);
    }
});