// inactivityTimeout.js
class InactivityTimeout {
    constructor(timeoutSeconds = 600) {
        this.timeoutSeconds = timeoutSeconds;
        this.timeoutId = null;
        this.events = [
            'mousedown',
            'mousemove',
            'keypress',
            'scroll',
            'touchstart',
            'click',
            'keydown',
            'keyup'
        ];
        
        this.startTimer = this.startTimer.bind(this);
        this.resetTimer = this.resetTimer.bind(this);
        this.logout = this.logout.bind(this);
        
        this.init();
    }
    
    init() {
        this.startTimer();
        
        this.events.forEach(event => {
            document.addEventListener(event, this.resetTimer);
        });
    }
    
    startTimer() {
        this.timeoutId = setTimeout(this.logout, this.timeoutSeconds * 1000);
    }
    
    resetTimer() {
        if (this.timeoutId) {
            clearTimeout(this.timeoutId);
        }
        this.startTimer();
    }
    
    async logout() {
        try {
            const response = await fetch('../../login/sair.php?timeout=true', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (response.ok) {
                // Redirecionar com o parâmetro de timeout
                window.location.href = '../../login/index.php?timeout=true';
            } else {
                console.error('Erro ao fazer logout');
                window.location.href = '../../login/index.php?timeout=true';
            }
        } catch (error) {
            console.error('Erro ao fazer logout:', error);
            window.location.href = '../../login/index.php?timeout=true';
        }
    }
}

// Inicializar o sistema de timeout com 10 minutos
const inactivityTimeout = new InactivityTimeout(600);

// Log para debug
console.log('Sistema de timeout inicializado');