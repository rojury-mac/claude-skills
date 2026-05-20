# INNOVA Landing — Instrucciones para WordPress

## Instalación (5 minutos)

1. **Sube el archivo** `template-landing-innova.php` a la carpeta de tu tema activo:
   ```
   /wp-content/themes/[nombre-de-tu-tema]/template-landing-innova.php
   ```
2. Ve a **WordPress Admin → Páginas → Añadir nueva**.
3. En el panel derecho, abre **"Atributos de página"** y selecciona la plantilla **"Landing INNOVA"**.
4. Dale un título (p. ej. *Inicio*) y pulsa **Publicar**.

---

## Qué debes cambiar tú

Busca las marcas `★` en el archivo PHP. Son exactamente **5 tipos de cambio**:

### ★ PDF — URL del catálogo (2 apariciones)

**Dónde:** línea ~165 (botón del hero) y línea ~270 (enlace del footer).

Sube el PDF a **Medios → Añadir nuevo** en WordPress.  
Copia la URL que te da WordPress y pégala en ambos sitios:

```php
<!-- Antes -->
href="/wp-content/uploads/innova-catalogo-lex-2026.pdf"

<!-- Después (ejemplo) -->
href="https://tudominio.com/wp-content/uploads/2026/05/innova-serie-lex.pdf"
```

---

### ★ WPFORMS — ID del formulario (1 aparición)

**Dónde:** línea ~286.

1. Crea el formulario en **WPForms → Añadir nuevo**.  
   Campos sugeridos: Nombre, Email, Teléfono, Tipo de proyecto, Mensaje.
2. Guárdalo y anota el **ID** que aparece en la columna "Acceso rápido" de la lista.
3. Reemplaza `XXXX` con ese número:

```php
<!-- Antes -->
<?php echo do_shortcode('[wpforms id="XXXX"]'); ?>

<!-- Después (ejemplo con ID 42) -->
<?php echo do_shortcode('[wpforms id="42"]'); ?>
```

El formulario hereda automáticamente el estilo visual de la landing.  
Si usas **Gravity Forms**: `[gravityforms id="42"]`  
Si usas **Contact Form 7**: `[contact-form-7 id="42"]`

---

### ★ IMAGEN-1 a IMAGEN-5 — Fotografías reales (5 apariciones)

**Dónde:** busca los comentarios `★ IMAGEN-1` … `★ IMAGEN-5`.

Cada slot tiene un bloque gris de marcador de posición. Sustitúyelo por una etiqueta `<img>`:

```html
<!-- Antes (placeholder gris) -->
<div class="iv-img-slot" style="aspect-ratio:4/5;">
  <span class="iv-img-slot__label">Fotografía de producto · 4:5</span>
</div>

<!-- Después (foto real) -->
<img src="https://tudominio.com/wp-content/uploads/2026/05/innova-hero.jpg"
     alt="Encimera INNOVA Serie LEX en cocina moderna"
     style="width:100%; aspect-ratio:4/5; object-fit:cover;">
```

| Slot       | Ratio | Descripción                        |
|------------|-------|------------------------------------|
| IMAGEN-1   | 4:5   | Hero principal (columna derecha)   |
| IMAGEN-2   | 16:9  | Galería — imagen grande            |
| IMAGEN-3/4 | 4:3   | Galería — fila de dos              |
| IMAGEN-5   | 3:4   | Bloque Material (columna izquierda)|

---

### ★ CONTACTO — Email y teléfono (1 aparición)

**Dónde:** línea ~280, sección "Contacto" del footer.

```html
<!-- Antes -->
<a href="mailto:info@innova.es">info@innova.es</a>
<a href="tel:+34900000000">+34 900 000 000</a>

<!-- Después -->
<a href="mailto:hola@tuempresa.com">hola@tuempresa.com</a>
<a href="tel:+34612345678">+34 612 345 678</a>
```

---

### ★ LEGAL — Política de privacidad (1 aparición)

**Dónde:** última línea antes del `</footer>`.

```html
<!-- Antes -->
<a href="/politica-de-privacidad">Política de privacidad</a>

<!-- Después (usa el slug real de tu página de privacidad) -->
<a href="<?php echo get_privacy_policy_url(); ?>">Política de privacidad</a>
```

O simplemente pon la URL directa:
```html
<a href="https://tudominio.com/aviso-legal">Aviso legal</a>
```

---

## Preguntas frecuentes

**¿El menú de WordPress aparece encima?**  
La plantilla llama a `wp_head()` y `wp_footer()` para que los plugins funcionen,
pero no incluye el header/footer del tema. Si tu tema los inyecta igualmente,
añade esto en `functions.php`:

```php
add_filter('show_admin_bar', '__return_false');
```

Y en la plantilla ya está gestionado porque no llama a `get_header()`.

**¿El formulario de WPForms no hereda el estilo?**  
En WPForms → Ajustes → General desactiva **"Incluir CSS de WPForms"** y el estilo
de la landing toma el control completamente.

**¿Cómo cambio el color de acento (azul pizarra)?**  
Busca en el CSS la sección `/* Tokens de diseño */` (al principio del `<style>`)
y cambia el valor de `--c-slate`. El resto de la paleta se ajusta solo.
