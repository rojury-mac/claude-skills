<?php
/**
 * Template Name: Landing INNOVA
 *
 * ─── INSTALACIÓN ───────────────────────────────────────────────────────────
 * 1. Sube esta carpeta completa a /wp-content/themes/[tu-tema]/innova-landing/
 *    (o copia solo este archivo al raíz del tema)
 * 2. En WordPress Admin → Páginas → Añadir nueva
 * 3. Panel derecho "Atributos de página" → Plantilla → "Landing INNOVA"
 * 4. Publica la página
 *
 * ─── CAMBIOS RÁPIDOS ───────────────────────────────────────────────────────
 * Busca los comentarios marcados con ★ para localizar cada punto de cambio:
 *
 *   ★ PDF        → URL del catálogo (aparece 2 veces: hero + footer)
 *   ★ WPFORMS    → ID de tu formulario WPForms
 *   ★ IMAGEN-X   → Slots para fotos reales (5 en total)
 *   ★ CONTACTO   → Email y teléfono en el footer
 *   ★ LEGAL      → Enlace a política de privacidad
 * ───────────────────────────────────────────────────────────────────────────
 */
?><!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php wp_title('·', true, 'right'); ?>INNOVA · Superficies Sólidas</title>
  <?php wp_head(); ?>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:ital,wght@0,400;1,400&display=swap" rel="stylesheet">

  <style>
    /* ================================================================
       INNOVA Landing · Estilos completos
       ================================================================ */

    /* --- Tokens de diseño --- */
    :root {
      --font-sans:      'Inter', ui-sans-serif, system-ui, sans-serif;
      --font-display:   'Playfair Display', Georgia, serif;
      --font-mono:      ui-monospace, 'SF Mono', 'Fira Mono', monospace;

      --c-ink:          #1A1A1C;
      --c-paper:        #FBFAF7;
      --c-bone:         #F5F3EE;
      --c-linen:        #EDE9E0;
      --c-mist:         #E2DDD4;
      --c-stone:        #C8C2B6;

      --c-graphite-300: #9B9590;
      --c-graphite-500: #6B6560;
      --c-graphite-700: #3E3A36;

      /* Escala de acento (derivada de #3C4860 pizarra) */
      --c-slate:        #3C4860;
      --c-slate-200:    #B0B8CC;
    }

    /* --- Reset mínimo --- */
    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin: 0; padding: 0; }
    body {
      font-family: var(--font-sans);
      color: var(--c-ink);
      background: var(--c-bone);
      -webkit-font-smoothing: antialiased;
      text-rendering: optimizeLegibility;
    }
    button { font: inherit; cursor: pointer; border: 0; background: transparent; color: inherit; }
    a { color: inherit; text-decoration: none; }
    img { display: block; max-width: 100%; }

    /* --- Etiqueta eyebrow --- */
    .iv-eyebrow {
      font-size: 11px;
      letter-spacing: 0.32em;
      text-transform: uppercase;
      color: var(--c-graphite-500);
      font-weight: 400;
      margin: 0 0 18px;
    }

    /* --- Tipografía --- */
    .iv-h2 {
      font-family: var(--font-sans);
      font-weight: 300;
      font-size: clamp(36px, 4vw, 64px);
      line-height: 1.06;
      letter-spacing: -0.02em;
      margin: 0 0 24px;
      color: var(--c-ink);
    }
    .iv-h2 em {
      font-family: var(--font-display);
      font-style: italic;
      font-weight: 400;
      letter-spacing: -0.03em;
    }
    .iv-body {
      font-size: 17px;
      line-height: 1.55;
      color: var(--c-graphite-700);
      margin: 0 0 18px;
      max-width: 56ch;
    }
    .iv-body em {
      font-family: var(--font-display);
      font-style: italic;
      font-weight: 400;
      letter-spacing: -0.01em;
    }

    /* --- Botones --- */
    .iv-btn {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 16px 24px;
      font-size: 12px;
      font-weight: 500;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      border-radius: 0;
      transition: all 240ms cubic-bezier(0.22, 1, 0.36, 1);
    }
    .iv-btn--primary {
      background: var(--c-ink);
      color: var(--c-paper);
      border: 1px solid var(--c-ink);
    }
    .iv-btn--primary:hover { background: var(--c-graphite-700); border-color: var(--c-graphite-700); }
    .iv-btn--ghost {
      background: transparent;
      border: 1px solid transparent;
      color: var(--c-ink);
      padding-left: 0;
      padding-right: 0;
    }
    .iv-btn--ghost::after { content: " →"; transition: transform 200ms ease; display: inline-block; }
    .iv-btn--ghost:hover { color: var(--c-slate); }
    .iv-btn--ghost:hover::after { transform: translateX(4px); }
    .iv-btn:focus-visible {
      outline: 2px solid var(--c-slate);
      outline-offset: 3px;
    }

    /* --- Cabecera --- */
    .iv-header {
      position: sticky;
      top: 0;
      z-index: 50;
      display: grid;
      grid-template-columns: 200px 1fr auto;
      align-items: center;
      gap: 32px;
      padding: 22px 48px;
      background: rgba(251,250,247,0.92);
      backdrop-filter: blur(8px);
      border-bottom: 1px solid var(--c-mist);
    }
    .iv-header__brand {
      font-family: var(--font-sans);
      font-weight: 300;
      font-size: 19px;
      letter-spacing: 0.15em;
      text-transform: uppercase;
    }
    .iv-header__nav { display: flex; gap: 36px; justify-content: center; }
    .iv-header__nav a {
      font-size: 12px;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: var(--c-graphite-700);
      padding: 6px 0;
      position: relative;
      transition: color 200ms ease;
    }
    .iv-header__nav a:hover { color: var(--c-ink); }
    .iv-header__cta {
      display: inline-block;
      font-size: 11px;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      padding: 12px 18px;
      border: 1px solid var(--c-ink);
      color: var(--c-ink);
      transition: all 200ms ease;
    }
    .iv-header__cta:hover { background: var(--c-ink); color: var(--c-paper); }

    /* --- Contenedor de sección --- */
    .iv-section {
      padding: 96px 48px;
      max-width: 1440px;
      margin: 0 auto;
    }

    /* --- Hero --- */
    .iv-hero {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      padding: 96px 48px 120px;
      align-items: center;
      max-width: 1440px;
      margin: 0 auto;
      min-height: calc(100vh - 80px);
    }
    .iv-hero__title {
      font-family: var(--font-sans);
      font-weight: 300;
      font-size: clamp(72px, 9vw, 144px);
      line-height: 0.98;
      letter-spacing: -0.04em;
      margin: 0 0 36px;
      color: var(--c-ink);
    }
    .iv-hero__title em {
      font-family: var(--font-display);
      font-style: italic;
      font-weight: 400;
      letter-spacing: -0.04em;
    }
    .iv-hero__lede {
      font-size: 19px;
      line-height: 1.5;
      color: var(--c-graphite-700);
      max-width: 38ch;
      margin: 0 0 40px;
    }
    .iv-hero__lede em {
      font-family: var(--font-display);
      font-style: italic;
      color: var(--c-ink);
    }
    .iv-hero__actions { display: flex; gap: 20px; align-items: center; flex-wrap: wrap; }

    /* --- Placeholder de imagen (reemplaza por <img> real) --- */
    .iv-img-slot {
      width: 100%;
      background: linear-gradient(135deg, var(--c-linen) 0%, var(--c-mist) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .iv-img-slot__label {
      font-size: 10px;
      letter-spacing: 0.32em;
      text-transform: uppercase;
      color: var(--c-stone);
      pointer-events: none;
    }
    .iv-img-slot img { width: 100%; height: 100%; object-fit: cover; display: block; }

    /* --- Bloque Quote --- */
    .iv-quote { text-align: left; max-width: 1100px; }
    .iv-quote__body {
      font-family: var(--font-display);
      font-style: italic;
      font-weight: 400;
      font-size: clamp(64px, 8vw, 132px);
      line-height: 0.96;
      letter-spacing: -0.04em;
      margin: 0 0 36px;
      color: var(--c-ink);
    }
    .iv-quote__sub {
      font-size: 19px;
      line-height: 1.55;
      max-width: 56ch;
      color: var(--c-graphite-700);
      margin: 0 0 12px;
    }
    .iv-quote__attr { font-size: 13px; color: var(--c-graphite-500); font-style: italic; }

    /* --- Galería de proyectos --- */
    .iv-proyectos {
      padding: 96px 48px 120px;
      max-width: 1600px;
      margin: 0 auto;
    }
    .iv-proyectos__head { max-width: 780px; margin: 0 auto 64px; text-align: center; }
    .iv-proyectos__head .iv-body { margin-left: auto; margin-right: auto; }
    .iv-proyectos__row { margin-bottom: 24px; }
    .iv-proyectos__row--split   { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    .iv-proyectos__row--triptych { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
    .iv-proyectos__big .iv-img-slot   { aspect-ratio: 16/9; }
    .iv-proyectos__row--split    .iv-img-slot,
    .iv-proyectos__row--triptych .iv-img-slot { aspect-ratio: 4/3; }

    /* --- Bloque Material --- */
    .iv-material {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      padding: 120px 48px;
      background: var(--c-paper);
      border-block: 1px solid var(--c-mist);
    }
    .iv-material__right { padding-top: 16px; }
    .iv-material .iv-img-slot { aspect-ratio: 3/4; }
    .iv-stats {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 32px 48px;
      margin: 40px 0 0;
    }
    .iv-stats > div { border-top: 1px solid var(--c-mist); padding-top: 16px; }
    .iv-stats dt {
      font-family: var(--font-display);
      font-style: italic;
      font-size: 56px;
      line-height: 1;
      letter-spacing: -0.03em;
      margin: 0 0 8px;
      color: var(--c-ink);
    }
    .iv-stats dd {
      margin: 0;
      font-size: 12px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--c-graphite-500);
    }

    /* --- Comparación acrílico --- */
    .iv-compare__head { max-width: 720px; margin: 0 auto 64px; text-align: center; }
    .iv-compare__head .iv-body { margin-left: auto; margin-right: auto; }
    .iv-compare__grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 48px; }
    .iv-compare__col {
      text-align: center;
      padding: 40px 24px;
      background: var(--c-paper);
      border: 1px solid var(--c-mist);
      position: relative;
    }
    .iv-compare__col--pure { background: var(--c-ink); color: var(--c-paper); border-color: var(--c-ink); }
    .iv-compare__no { font-size: 11px; letter-spacing: 0.22em; color: var(--c-graphite-500); margin: 0 0 24px; }
    .iv-compare__col--pure .iv-compare__no { color: rgba(251,250,247,0.5); }
    .iv-compare__pct {
      font-family: var(--font-display);
      font-style: italic;
      font-size: 88px;
      line-height: 1;
      letter-spacing: -0.04em;
      color: var(--c-graphite-300);
      margin: 0;
    }
    .iv-compare__col--pure .iv-compare__pct { color: var(--c-paper); }
    .iv-compare__lbl { font-size: 11px; letter-spacing: 0.32em; text-transform: uppercase; margin: 4px 0 28px; }
    .iv-compare__note { font-size: 14px; color: var(--c-graphite-500); margin: 0; }
    .iv-compare__col--pure .iv-compare__note { color: var(--c-paper); font-weight: 500; }
    .iv-compare__mark {
      position: absolute;
      top: 16px;
      right: 20px;
      font-size: 10px;
      letter-spacing: 0.32em;
      color: rgba(251,250,247,0.6);
    }

    /* --- Sección presupuesto --- */
    .iv-studio { max-width: 880px; }
    .iv-studio__head { margin-bottom: 56px; }

    /* Adaptación visual de WPForms al estilo INNOVA */
    .iv-studio .wpforms-container { max-width: none !important; }
    .iv-studio .wpforms-field-label,
    .iv-studio .wpforms-field-label-inline {
      font-size: 10px !important;
      letter-spacing: 0.32em !important;
      text-transform: uppercase !important;
      color: var(--c-graphite-500) !important;
      font-weight: 400 !important;
      font-family: var(--font-sans) !important;
    }
    .iv-studio .wpforms-field input:not([type="submit"]),
    .iv-studio .wpforms-field select,
    .iv-studio .wpforms-field textarea {
      border: 0 !important;
      border-bottom: 1px solid var(--c-mist) !important;
      border-radius: 0 !important;
      background: transparent !important;
      box-shadow: none !important;
      padding: 10px 0 12px !important;
      font-family: var(--font-sans) !important;
      font-size: 16px !important;
      color: var(--c-ink) !important;
    }
    .iv-studio .wpforms-field input:focus,
    .iv-studio .wpforms-field select:focus,
    .iv-studio .wpforms-field textarea:focus {
      border-bottom-color: var(--c-slate) !important;
      outline: none !important;
      box-shadow: none !important;
    }
    .iv-studio .wpforms-submit-container .wpforms-submit,
    .iv-studio button[type="submit"] {
      display: inline-flex !important;
      align-items: center !important;
      padding: 16px 24px !important;
      font-size: 12px !important;
      font-weight: 500 !important;
      letter-spacing: 0.18em !important;
      text-transform: uppercase !important;
      background: var(--c-ink) !important;
      color: var(--c-paper) !important;
      border: 1px solid var(--c-ink) !important;
      border-radius: 0 !important;
      transition: all 240ms cubic-bezier(0.22, 1, 0.36, 1) !important;
    }
    .iv-studio .wpforms-submit:hover,
    .iv-studio button[type="submit"]:hover {
      background: var(--c-graphite-700) !important;
      border-color: var(--c-graphite-700) !important;
    }

    /* --- Footer --- */
    .iv-footer { background: var(--c-ink); color: var(--c-paper); padding: 80px 48px 32px; }
    .iv-footer__top {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 80px;
      max-width: 1440px;
      margin: 0 auto 64px;
    }
    .iv-footer__brand {
      font-family: var(--font-sans);
      font-weight: 300;
      font-size: 20px;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      margin: 0 0 16px;
    }
    .iv-footer__tag { margin: 0; }
    .iv-footer__tag em {
      font-family: var(--font-display);
      font-style: italic;
      font-weight: 400;
      font-size: 28px;
      letter-spacing: -0.02em;
    }
    .iv-footer__cols { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; }
    .iv-footer__cols h4 {
      font-size: 10px;
      letter-spacing: 0.32em;
      text-transform: uppercase;
      color: rgba(251,250,247,0.5);
      font-weight: 400;
      margin: 0 0 18px;
    }
    .iv-footer__cols ul {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .iv-footer__cols a {
      font-size: 14px;
      color: var(--c-paper);
      transition: color 200ms ease;
    }
    .iv-footer__cols a:hover { color: var(--c-slate-200); }
    .iv-footer__bottom {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1440px;
      margin: 0 auto;
      padding-top: 32px;
      border-top: 1px solid rgba(251,250,247,0.1);
      font-size: 11px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: rgba(251,250,247,0.5);
      gap: 24px;
      flex-wrap: wrap;
    }
    .iv-footer__bottom a { color: rgba(251,250,247,0.5); transition: color 200ms ease; }
    .iv-footer__bottom a:hover { color: var(--c-paper); }
  </style>
</head>
<body <?php body_class('innova-landing'); ?>>
<?php wp_body_open(); ?>

<!-- ============================================================
     CABECERA
     Contiene: logotipo | navegación | CTA
     ============================================================ -->
<header class="iv-header" id="inicio">

  <div class="iv-header__brand">
    <a href="https://innovasp.com" target="_blank" rel="noopener noreferrer">
      <img 
        src="https://www.innovasp.com/wp-content/uploads/2020/05/innovasp.png" 
        alt="Innova SP"
        style="height: 50px; width: auto;"
      >
    </a>
  </div>

  <a href="#presupuesto" class="iv-header__cta">Presupuesto</a>

</header>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="iv-hero" aria-labelledby="hero-titulo">

  <div>
    <p class="iv-eyebrow">Serie LEX 2026</p>

    <h1 class="iv-hero__title" id="hero-titulo">
      Marca la<br><em>diferencia.</em>
    </h1>

    <p class="iv-hero__lede">
      Superficies sólidas de <em>100&nbsp;% acrílico puro</em> para cocinas,
      baños y espacios de alto rendimiento.
    </p>

    <div class="iv-hero__actions">

      <!-- ★ PDF — cambia esta URL por la ruta real a tu catálogo -->
      <a href="/wp-content/uploads/2026/05/INNOVA_Serie_LEX.pdf"
         class="iv-btn iv-btn--primary"
         target="_blank"
         rel="noopener noreferrer">
        Ver catálogo
      </a>

      <a href="#presupuesto" class="iv-btn iv-btn--ghost">Solicitar presupuesto</a>

    </div>
  </div>

  <div>
    <!-- ★ IMAGEN-1 — sustituye el bloque .iv-img-slot por una etiqueta <img> real:
         <img src="/wp-content/uploads/innova-hero.jpg"
              alt="Encimera INNOVA Serie LEX en cocina moderna"
              style="width:100%;aspect-ratio:4/5;object-fit:cover;">         -->
   <div>
  <img src="https://www.innovasp.com/wp-content/uploads/2026/05/ENCIMERA-LEX-04.jpg"
       alt="Encimera INNOVA Serie LEX"
       style="width:100%; aspect-ratio:4/5; object-fit:cover;">
</div>
  </div>

</section>


<!-- ============================================================
     QUOTE EDITORIAL
     ============================================================ -->
<section class="iv-section">
  <div class="iv-quote">
    <p class="iv-quote__body">Dos piezas,<br>cero juntas</p>
    <p class="iv-quote__sub">
      El lavabo se une a la encimera formando una única superficie en continuidad, sin fisuras ni acumulación de suciedad. La higiene es prioridad.
    </p>
    <p class="iv-quote__attr">— Serie LEX, por Innova.</p>
  </div>
</section>


<!-- ============================================================
     GALERÍA DE PROYECTOS
     ============================================================ -->
<section class="iv-proyectos">

  <div class="iv-proyectos__head">
    <p class="iv-eyebrow">Proyectos</p>
    <h2 class="iv-h2"><em>Ambientes.</em></h2>
    <p class="iv-body">
      Cada pieza de INNOVA está fabricada con Solid Surface 100% acrílico, sin rellenos ni impurezas. Una superficie que no solo dura, sino que se mantiene impecable con el tiempo.
    </p>
  </div>

  <!-- Imagen grande 16:9 -->
  <div class="iv-proyectos__row iv-proyectos__big">
    <!-- ★ IMAGEN-2 — imagen principal de galería (16:9) -->
    <div>
  <img src="https://www.innovasp.com/wp-content/uploads/2026/05/ENCIMERA-LEX-01.jpg"
       alt="Encimera INNOVA Serie LEX"
       style="width:100%; aspect-ratio:16/9; object-fit:cover;">
</div>
  </div>

  <!-- Fila de dos imágenes -->
  <div class="iv-proyectos__row iv-proyectos__row--split">
  <div>
    <img src="https://www.innovasp.com/wp-content/uploads/2026/05/ENCIMERA-LEX-03.jpg"
         alt="Encimera INNOVA Serie LEX"
         style="width:100%; aspect-ratio:4/3; object-fit:cover;">
  </div>

  <div>
    <img src="https://www.innovasp.com/wp-content/uploads/2026/05/ENCIMERA-LEX-02.jpg"
         alt="Encimera INNOVA Serie LEX"
         style="width:100%; aspect-ratio:4/3; object-fit:cover;">
  </div>
</div>

<!-- Fila de tres detalles -->
<div class="iv-proyectos__row iv-proyectos__row--triptych">
  <div>
    <img src="https://www.innovasp.com/wp-content/uploads/2026/05/ENCIMERA-LEX-05.jpg"
         alt="Detalle encimera INNOVA Serie LEX"
         style="width:100%; aspect-ratio:1/1; object-fit:cover;">
  </div>
  <div>
    <img src="https://www.innovasp.com/wp-content/uploads/2026/05/ENCIMERA-LEX-06.jpg"
         alt="Detalle encimera INNOVA Serie LEX"
         style="width:100%; aspect-ratio:1/1; object-fit:cover;">
  </div>
  <div>
    <img src="https://www.innovasp.com/wp-content/uploads/2026/05/ENCIMERA-LEX-07.jpg"
         alt="Detalle encimera INNOVA Serie LEX"
         style="width:100%; aspect-ratio:1/1; object-fit:cover;">
  </div>
</div>

</section>

<!-- ============================================================
     COMPARACIÓN DE ACRÍLICO
     ============================================================ -->
<section class="iv-section">

  <div class="iv-compare__head">
    <p class="iv-eyebrow">Material</p>
    <h2 class="iv-h2">No todo el Solid Surface<br><em>es igual.</em></h2>
    <p class="iv-body">El porcentaje de acrílico marca la longevidad del color.</p>
  </div>

  <div class="iv-compare__grid">

    <div class="iv-compare__col">
      <p class="iv-compare__no">Alternativas económicas</p>
      <p class="iv-compare__pct">2%</p>
      <p class="iv-compare__lbl">Acrílico</p>
      <p class="iv-compare__note">Absorbe manchas. No se repara. Decolora.</p>
    </div>

    <div class="iv-compare__col">
      <p class="iv-compare__no">Gama media</p>
      <p class="iv-compare__pct">10%</p>
      <p class="iv-compare__lbl">Acrílico</p>
      <p class="iv-compare__note">Mejor que lo básico. Limitaciones con el calor.</p>
    </div>

    <div class="iv-compare__col iv-compare__col--pure">
      <span class="iv-compare__mark">INNOVA</span>
      <p class="iv-compare__no">Serie LEX</p>
      <p class="iv-compare__pct">100%</p>
      <p class="iv-compare__lbl">Acrílico puro</p>
      <p class="iv-compare__note">Blanco por siempre.</p>
    </div>

  </div>

</section>


<!-- ============================================================
     FORMULARIO DE PRESUPUESTO
     ============================================================ -->
<section class="iv-section" id="presupuesto">
  <div class="iv-studio">

    <div class="iv-studio__head">
      <p class="iv-eyebrow">Contacto</p>
      <h2 class="iv-h2">Solicita tu<br><em>presupuesto.</em></h2>
      <p class="iv-body">
        Cuéntanos tu proyecto y te respondemos en menos de 24&nbsp;horas.
      </p>
    </div>

    <!-- ★ WPFORMS — reemplaza XXXX por el ID de tu formulario en WPForms
         Pasos: WPForms → Todos los formularios → anota el ID de la columna "Acceso rápido"
         Si usas Gravity Forms: [gravityforms id="XXXX"]
         Si usas Contact Form 7: [contact-form-7 id="XXXX"]              -->
    <?php echo do_shortcode('[wpforms id="XXXX"]'); ?>

  </div>
</section>


<!-- ============================================================
     PIE DE PÁGINA
     ============================================================ -->
<footer class="iv-footer">

  <div class="iv-footer__top">

   <div>
  <img src="https://www.innovasp.com/wp-content/uploads/2020/05/innovasp.png"
       alt="INNOVA Superficies Sólidas"
       style="max-width:180px; height:auto;">
</div>

    <div class="iv-footer__cols">


      <div>
        <h4>Empresa</h4>
        <ul>
          <li><a href="https://www.innovasp.com/#proyectos">Proyectos</a></li>
          <li>
            <a href="/wp-content/uploads/2026/05/INNOVA_Serie_LEX.pdf"
               target="_blank" rel="noopener">Catálogo PDF</a>
          </li>
        </ul>
      </div>

      <div>
        <h4>Contacto</h4>
        <ul>
          <!-- ★ CONTACTO — pon tu email y teléfono reales -->
          <li><a href="mailto:proyectos@innovasp.com">proyectos@innovasp.com</a></li>
          <li><a href="tel:+34670966509">+34 670 96 65 09</a></li>
        </ul>
      </div>

    </div>
  </div>

  <div class="iv-footer__bottom">
    <span>© <?php echo date('Y'); ?> INNOVA · Superficies Sólidas</span>
    <!-- ★ LEGAL — enlaza a tu política de privacidad real -->
    <a href="/politica-de-privacidad">Política de privacidad</a>
  </div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
