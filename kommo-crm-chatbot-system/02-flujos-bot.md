# 2. Flujos del Bot

## 2.1 Flujo 1 — Bienvenida y Calificación Inicial

```
TRIGGER: Mensaje entrante (primer contacto)
         └─ Canal: WhatsApp Business / Instagram DM / Web Chat

BOT: "¡Hola! 👋 Soy [Nombre del Bot] de [Empresa].
      ¿Con quién tengo el gusto?"

USUARIO: [responde nombre]
         └─ CRM: Actualiza campo "Nombre" en contacto

BOT: "Gracias, [Nombre]. ¿En qué te puedo ayudar hoy?"

MENÚ RÁPIDO:
  [1] Información de productos/servicios
  [2] Cotización / Precio
  [3] Soporte técnico
  [4] Hablar con un asesor
  [5] Otro

SEGÚN OPCIÓN → Flujo específico (ver 2.2 a 2.6)
```

**Regla de timeout:** Si no responde en 10 minutos → enviar recordatorio.
Si no responde en 24 horas → marcar lead como "Inactivo" y mover a Nurturing.

---

## 2.2 Flujo 2 — Calificación Profunda (Ventas)

```
TRIGGER: Usuario elige opción 1, 2 o 4

BOT: "Para darte la mejor atención, necesito hacerte
      unas preguntas rápidas (menos de 2 minutos)."

── PREGUNTA 1 (Necesidad) ──────────────────────────
BOT: "¿Qué problema o necesidad principal quieres resolver?"
USUARIO: [respuesta libre]
CRM: Guarda en campo "Necesidad_Principal"

── PREGUNTA 2 (Urgencia) ────────────────────────────
BOT: "¿Cuándo necesitas una solución?"
  [A] Esta semana
  [B] Este mes
  [C] En los próximos 3 meses
  [D] Estoy explorando opciones
CRM: Guarda en "Urgencia" → mapea a puntuación (A=4, B=3, C=2, D=1)

── PREGUNTA 3 (Presupuesto) ─────────────────────────
BOT: "¿Cuentas con un presupuesto aproximado definido?"
  [A] Sí, menos de $X
  [B] Sí, entre $X y $Y
  [C] Sí, más de $Y
  [D] Aún no lo tengo definido
CRM: Guarda en "Rango_Presupuesto"

── PREGUNTA 4 (Rol decisor) ─────────────────────────
BOT: "¿Eres la persona que tomará la decisión de compra?"
  [A] Sí, soy el decisor
  [B] Soy parte del equipo que decide
  [C] Necesito aprobación de un superior
CRM: Guarda en "Rol_Decisor"

── CALCULAR LEAD SCORE ──────────────────────────────
Score = Urgencia(1-4) + Presupuesto(1-3) + Rol(3/2/1) + [otros factores]
  Score ≥ 6  → Lead CALIENTE → Flujo 2A (Transferencia a Humano)
  Score 3-5  → Lead TIBIO   → Flujo 2B (Nurturing automatizado)
  Score < 3  → Lead FRÍO    → Flujo 2C (Contenido educativo)
```

### Flujo 2A — Lead Caliente (Transferencia)
```
BOT: "Perfecto, [Nombre]. Tienes un perfil ideal para
      hablar directamente con uno de nuestros asesores.
      ¿Cuál es el mejor momento para llamarte?"

  [A] Ahora mismo
  [B] Esta tarde (indicar hora)
  [C] Mañana por la mañana
  [D] Prefiero continuar por chat

→ CRM: Crea tarea "Llamar a [Nombre]" asignada al agente disponible
→ CRM: Mueve lead a etapa "Contacto Humano"
→ Bot: Notifica al agente por la app de Kommo
```

### Flujo 2B — Lead Tibio (Nurturing)
```
BOT: "Gracias por tu información. Te enviaré material
      relevante y un asesor te contactará pronto."

→ CRM: Etiqueta "nurturing_activo"
→ CRM: Inicia secuencia de mensajes (ver sección 4)
→ CRM: Agenda revisión en 7 días
```

### Flujo 2C — Lead Frío
```
BOT: "Entiendo que aún estás explorando. Te comparto
      recursos que pueden ayudarte a evaluar mejor
      tus opciones."

→ Envía enlace a blog / caso de éxito / video
→ CRM: Etiqueta "lead_frio"
→ CRM: Agenda seguimiento en 30 días
```

---

## 2.3 Flujo 3 — Soporte Técnico

```
TRIGGER: Usuario elige opción 3, o escribe palabras clave:
         "problema", "error", "no funciona", "ayuda", "falla"

BOT: "Lamento escuchar eso. Voy a ayudarte a resolverlo.
      ¿Eres cliente actual?"

  [A] Sí, tengo contrato/cuenta activa
  [B] No, soy nuevo usuario

─── Si responde A (Cliente existente) ──────────────
BOT: "¿Puedes compartirme tu número de cliente o
      correo registrado?"
USUARIO: [dato]
CRM: Busca contacto existente → vincula conversación
BOT: Muestra opciones de problemas frecuentes (FAQ dinámica)
     Si no resuelve → Escala a agente de soporte
     CRM: Crea ticket en Pipeline de Soporte, etapa "Triaje"

─── Si responde B (No cliente) ──────────────────────
BOT: "Para ayudarte necesito registrarte primero."
→ Deriva a Flujo 1 (Calificación)
```

---

## 2.4 Flujo 4 — FAQ Automático

```
TRIGGER: Palabras clave detectadas en el mensaje del usuario

MAPA DE INTENCIONES:
┌────────────────────────────┬────────────────────────────────────┐
│ Palabras clave             │ Respuesta / Acción                 │
├────────────────────────────┼────────────────────────────────────┤
│ precio, costo, cuánto vale │ Envía tabla de precios / landing   │
│ horario, horarios, abierto │ Informa horario de atención        │
│ dirección, ubicación, dónde│ Envía ubicación / Google Maps link │
│ descuento, promoción, oferta│ Muestra promociones vigentes      │
│ factura, facturación       │ Proceso de facturación / contacto  │
│ cancelar, baja, cancelación│ → Flujo de retención               │
│ hablar con humano, asesor  │ → Flujo 2A (Transferencia directa) │
└────────────────────────────┴────────────────────────────────────┘
```

---

## 2.5 Flujo 5 — Retención (Anti-Cancelación)

```
TRIGGER: Usuario menciona "cancelar", "darme de baja", "terminar contrato"

BOT: "Lamento escuchar eso, [Nombre]. Antes de proceder,
      ¿podrías contarme qué no está funcionando para ti?"

USUARIO: [motivo]
CRM: Registra en campo "Motivo_Cancelacion"
CRM: Alerta urgente al supervisor / responsable de cuenta

BOT: Ofrece alternativa según motivo:
  - Precio → Ofrece plan reducido o descuento de retención
  - Problema técnico → Escala a soporte prioritario
  - No usa el servicio → Ofrece onboarding/capacitación
  - Competidor → Presenta diferenciadores clave

CRM: Crea tarea "RETENCIÓN URGENTE" con prioridad alta
CRM: Etiqueta lead como "riesgo_cancelacion"
```

---

## 2.6 Flujo 6 — Cierre y Confirmación de Venta

```
TRIGGER: Agente marca deal como "Propuesta Aceptada"

BOT (automatizado): "¡Excelente noticia, [Nombre]! 🎉
                     Tu contratación ha sido confirmada.
                     Recibirás los siguientes pasos por este medio."

Acciones automáticas:
→ Envía enlace de pago o instrucciones
→ Crea contacto en sistema de facturación (si integrado)
→ Asigna responsable de onboarding
→ Agenda mensaje de bienvenida a los 3 días
→ CRM: Mueve a Pipeline Post-venta
```

---

## 2.7 Manejo de Excepciones

| Situación | Acción del Bot | Acción en CRM |
|-----------|---------------|---------------|
| Mensaje incomprensible (3 veces) | "Permíteme conectarte con un asesor" | Escala a humano, etiqueta "escalado" |
| Insultos / lenguaje inapropiado | "Solo puedo ayudarte con consultas sobre [X]" | Registra nota, bloqueo opcional |
| Fuera de horario laboral | Informa horario, ofrece callback | Crea tarea para el siguiente día hábil |
| El bot no sabe la respuesta | Reconoce limitación, escala | Crea nota "pregunta sin respuesta" para mejorar FAQ |
| Usuario solicita hablar con humano | Transfiere inmediatamente | Sin demora, notifica agente disponible |
