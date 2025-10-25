<style>
    body {
        background: linear-gradient(45deg, #0d6efd 0%, #0dcaf0 100%);
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        font-family: 'Arial', sans-serif;
        size: 14px;
    }

    .container {
        text-align: center;
    }

    .rocket {
        font-size: 10rem;
        margin-bottom: 20px;
        transition: transform 3s ease-in-out;
    }

    .rocket.fly {
        transform: translateY(100vh) rotate(45deg);
    }

    .btn-glass {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        transition: all 0.3s ease;
        height: 35px;
    }

    .btn-glass:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
    }

    .error-code {
        font-size: 5rem;
        font-weight: 900;
        background: linear-gradient(to right, #fff, rgba(255, 255, 255, 0.5));
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }
</style>

<div class="container">
    <div class="rocket">🪁</div>
    <h1 class="error-code">404</h1>
    <p class="lead">Oops! Página não encontrada.</p>
    <p>Parece que você se perdeu no espaço. Vamos te levar de volta!</p>
    <button id="launchRocket" class="btn-glass">Recolher linha</button>
</div>


<!-- Script para interação -->
<script>
    document.getElementById('launchRocket').addEventListener('click', function() {
        const rocket = document.querySelector('.rocket');
        rocket.classList.add('fly');
        setTimeout(() => {
            window.location.href = '/';
        }, 2000);
    });
</script>