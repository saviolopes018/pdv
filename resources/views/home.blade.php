<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Home – Dois Botões</title>

  <!-- jQuery (para o efeito ripple) -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <style>
    :root {
      --bg: #0f1115;
      --fg: #e6e9ef;
      --muted: #8a8f98;

      --btn-1: #4f46e5;   /* Indigo */
      --btn-1-hover: #4338ca;
      --btn-2: #ef4444;   /* Red */
      --btn-2-hover: #dc2626;

      --radius: 14px;
      --shadow: 0 10px 30px -15px rgba(0, 0, 0, .5);
      --transition: 180ms cubic-bezier(.2,.8,.2,1);
    }

    @media (prefers-color-scheme: light) {
      :root {
        --bg: #f6f7fb;
        --fg: #111827;
        --muted: #6b7280;

        --shadow: 0 10px 30px -20px rgba(0, 0, 0, .15);
      }
    }

    * {
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      margin: 0;
      background: var(--bg);
      color: var(--fg);
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Ubuntu, "Helvetica Neue", sans-serif;
    }

    body {
      display: grid;
      place-items: center;
      overflow: hidden;
      animation: fadeIn .6s ease both;
    }

    .wrapper {
      text-align: center;
      display: flex;
      flex-direction: column;
      gap: 2.5rem;
      align-items: center;
      padding: 2rem;
    }

    h1 {
      font-size: clamp(1.8rem, 4vw, 2.6rem);
      font-weight: 700;
      letter-spacing: -0.02em;
      margin: 0;
    }

    p {
      margin: 0;
      color: var(--muted);
      max-width: 46ch;
    }

    .buttons {
      display: flex;
      gap: 1.25rem;
      flex-wrap: wrap;
      justify-content: center;
    }

    .btn {
      position: relative;
      overflow: hidden; /* para o ripple */
      min-width: 180px;
      height: 56px;
      padding: 0 1.5rem;
      border: 0;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      color: #fff;
      font-size: 1rem;
      font-weight: 600;
      letter-spacing: .01em;
      cursor: pointer;
      transition: transform var(--transition), box-shadow var(--transition), filter var(--transition);
      outline: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      will-change: transform;
      text-decoration: none;
    }

    .btn:focus-visible {
      outline: 2px solid rgba(255, 255, 255, 0.6);
      outline-offset: 2px;
    }

    .btn:hover {
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 14px 40px -18px rgba(0,0,0,.6);
      filter: brightness(1.02);
    }

    .btn:active {
      transform: translateY(0) scale(0.99);
    }

    .btn--a {
      background: var(--btn-1);
    }
    .btn--a:hover {
      background: var(--btn-1-hover);
    }

    .btn--b {
      background: var(--btn-2);
    }
    .btn--b:hover {
      background: var(--btn-2-hover);
    }

    /* Ripple element */
    .ripple {
      position: absolute;
      border-radius: 50%;
      transform: scale(0);
      animation: ripple .6s linear;
      background: rgba(255, 255, 255, 0.35);
      pointer-events: none;
    }

    /* BG com gradiente sutil animado */
    .bg-gradient {
      position: fixed;
      inset: -50%;
      background: radial-gradient(circle at 50% 50%, rgba(79,70,229,.08), transparent 50%),
                  radial-gradient(circle at 80% 20%, rgba(239,68,68,.06), transparent 40%),
                  radial-gradient(circle at 20% 80%, rgba(255,255,255,.025), transparent 40%);
      animation: float 18s ease-in-out infinite alternate;
      z-index: -1;
      filter: blur(40px);
    }

    @keyframes ripple {
      to {
        transform: scale(4);
        opacity: 0;
      }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(6px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes float {
      0%   { transform: translate(0, 0) scale(1); }
      100% { transform: translate(-5%, 3%) scale(1.05); }
    }

    @media (prefers-reduced-motion: reduce) {
      * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
      }
    }
  </style>
</head>
<body>
  <div class="bg-gradient"></div>

  <main class="wrapper" role="main">
    <h1>Escolha a operação que deseja iniciar<h1>

    <div class="buttons">
      <a class="btn btn--a" id="btnA" href="{{ route('pdv') }}" target="_blank">PDV</a>
      <a class="btn btn--b" id="btnB" href="{{ route('dashboard') }}" target="_blank">Gestão</a>
    </div>
  </main>

  <script>
    // Efeito ripple usando jQuery
    $('.btn').on('click', function (e) {
      const $btn = $(this);
      const offset = $btn.offset();
      const x = e.pageX - offset.left;
      const y = e.pageY - offset.top;

      const $ripple = $('<span class="ripple"></span>').css({
        top: y + 'px',
        left: x + 'px',
        width: Math.max($btn.outerWidth(), $btn.outerHeight()) * 2 + 'px',
        height: Math.max($btn.outerWidth(), $btn.outerHeight()) * 2 + 'px'
      });

      $btn.append($ripple);

      // remove quando termina a animação
      setTimeout(() => $ripple.remove(), 600);
    });

    // Exemplos de ações
    $('#btnA').on('click', () => {
      console.log('Botão A clicado');
      // redirecione, abra modal, etc.
    });

    $('#btnB').on('click', () => {
      console.log('Botão B clicado');
      // redirecione, abra modal, etc.
    });
  </script>
</body>
</html>
