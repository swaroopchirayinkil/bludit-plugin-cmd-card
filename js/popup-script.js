(function() {
    'use strict';
    
    const COOKIE_NAME = 'linux_cmd_popup_shown';
    const DISPLAY_DURATION = 10000; // 10 seconds
    const COOKIE_EXPIRY_HOURS = 24;
    
    function setCookie(name, value, hours) {
        const date = new Date();
        date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }
    
    function getCookie(name) {
        const nameEQ = name + "=";
        const cookies = document.cookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            let cookie = cookies[i];
            while (cookie.charAt(0) === ' ') {
                cookie = cookie.substring(1);
            }
            if (cookie.indexOf(nameEQ) === 0) {
                return cookie.substring(nameEQ.length, cookie.length);
            }
        }
        return null;
    }
    
    function showPopup() {
        const popup = document.getElementById('linux-cmd-popup');
        if (!popup) return;
        
        // Check if already shown
        if (getCookie(COOKIE_NAME)) {
            return;
        }
        
        // Show popup with animation
        setTimeout(function() {
            popup.classList.add('show');
        }, 500);
        
        // Auto-hide after duration
        setTimeout(function() {
            hidePopup();
        }, DISPLAY_DURATION);
        
        // Set cookie
        setCookie(COOKIE_NAME, '1', COOKIE_EXPIRY_HOURS);
    }
    
    function hidePopup() {
        const popup = document.getElementById('linux-cmd-popup');
        if (!popup) return;
        
        popup.classList.remove('show');
        popup.classList.add('hide');
        
        setTimeout(function() {
            popup.style.display = 'none';
        }, 400);
    }
    
    // Close button handler
    const closeBtn = document.getElementById('close-popup');
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            hidePopup();
        });
    }
    
    // Initialize
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', showPopup);
    } else {
        showPopup();
    }
})();
