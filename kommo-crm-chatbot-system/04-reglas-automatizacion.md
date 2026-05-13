# 4. Reglas de Automatización

> Todas las automatizaciones se configuran en Kommo en: **Configuración → Automatizaciones**
> Kommo las llama "Salesbots" (flujos del bot) y "Triggers" (disparadores de automatización).

---

## 4.1 Automatizaciones de Entrada (Lead Capture)

### AUTO-01: Creación de Lead al Primer Mensaje
```
CUANDO:  Llega mensaje nuevo de un contacto que no tiene deal activo
HACER:
  1. Crear nuevo deal en Pipeline Principal, etapa "Entrada"
  2. Registrar canal de origen en campo Canal_Origen
  3. Registrar Fecha_Primer_Contacto = ahora
  4. Asignar etiqueta "bot_activo"
  5. Iniciar Salesbot: "Flujo Bienvenida"
  6. Notificar al supervisor (resumen diario, no alerta inmediata)
```

### AUTO-02: Deduplicación de Contactos
```
CUANDO:  Se crea contacto nuevo
HACER:
  1. Buscar coincidencia por número de WhatsApp o email
  2. SI existe → Fusionar datos, vincular al deal existente
  3. SI no existe → Continuar creación normal
  4. Registrar nota: "Contacto creado vía [canal] en [fecha]"
```

---

## 4.2 Automatizaciones de Calificación

### AUTO-03: Asignación por Lead Score
```
CUANDO:  Campo Lead_Score es actualizado
HACER:
  SI Lead_Score ≥ 8:
    → Cambiar Temperatura_Lead = "Caliente"
    → Asignar a agente de ventas senior (round-robin del grupo "Senior")
    → Mover etapa → "Contacto Humano"
    → Enviar notificación push al agente asignado
    → Crear tarea: "Contactar URGENTE en < 1 hora"

  SI Lead_Score entre 5 y 7:
    → Cambiar Temperatura_Lead = "Tibio"
    → Asignar a agente de ventas (round-robin general)
    → Crear tarea: "Primer contacto en < 4 horas"

  SI Lead_Score < 5:
    → Cambiar Temperatura_Lead = "Frío"
    → NO asignar agente aún
    → Iniciar secuencia de nurturing (AUTO-06)
```

### AUTO-04: SLA de Respuesta — Alerta de Demora
```
CUANDO:  Deal en etapa "Contacto Humano" sin actividad por 1 hora
HACER:
  1. Enviar alerta al agente asignado: "Lead esperando respuesta"
  2. SI pasan 2 horas sin actividad → Alerta al supervisor
  3. SI pasan 4 horas sin actividad → Reasignar a agente disponible
  4. Registrar nota: "SLA incumplido en [fecha/hora]"
```

---

## 4.3 Secuencias de Nurturing

### AUTO-05: Secuencia Nurturing — Lead Tibio (7 mensajes en 30 días)

```
Día 0  (inmediato):
  → WhatsApp: "Hola [Nombre], te comparto este caso de éxito
               que puede ayudarte: [link]"

Día 2:
  → WhatsApp: "¿Tuviste oportunidad de revisar el material?
               Cuéntame si tienes dudas."

Día 5:
  → WhatsApp: Artículo o video relevante + pregunta de enganche

Día 10:
  → WhatsApp: "Esta semana tenemos disponibilidad para una
               demo de 20 minutos. ¿Te interesa?"
  → SI responde SÍ → Inicia Flujo 2A (Transferencia)
  → SI responde NO → Continúa secuencia

Día 15:
  → Email: Caso de estudio detallado (si tiene email registrado)

Día 22:
  → WhatsApp: Oferta especial por tiempo limitado

Día 30:
  → WhatsApp: "¿Sigues interesado en [solución]? Si el momento
               no es el adecuado, está bien. ¿Cuándo sería
               mejor contactarte?"
  → SI no responde → Mover a "Lead Frío" y pausar secuencia
```

### AUTO-06: Secuencia Nurturing — Lead Frío (4 mensajes en 90 días)

```
Día 0:
  → WhatsApp: Material educativo sin presión de venta

Día 30:
  → WhatsApp: "Han pasado 30 días, ¿algo ha cambiado en
               tus planes?"

Día 60:
  → WhatsApp: Tendencias del sector / contenido de valor

Día 90:
  → WhatsApp: "Último mensaje por ahora. Si en el futuro
               necesitas [solución], aquí estaremos."
  → Marcar deal como "Perdido" motivo: "Sin interés por ahora"
  → Mantener contacto activo para campañas futuras
```

---

## 4.4 Automatizaciones de Seguimiento

### AUTO-07: Recordatorio de Tarea Vencida
```
CUANDO:  Tarea vence y no está completada
HACER:
  1. Notificar al agente responsable
  2. Si venció hace más de 2 horas → Notificar al supervisor
  3. Registrar en el deal: "Tarea vencida: [descripción]"
```

### AUTO-08: Actualización de Fecha de Último Contacto
```
CUANDO:  Se registra nota, mensaje o llamada en el deal
HACER:
  1. Actualizar campo Fecha_Ultimo_Contacto = ahora
  2. Limpiar etiqueta "sin_actividad" si existe
```

### AUTO-09: Detección de Stale Deals (Deals sin actividad)
```
CUANDO:  Deal sin actividad por N días según etapa:
  Etapa "Calificación"     → 3 días sin actividad
  Etapa "Contacto Humano"  → 5 días sin actividad
  Etapa "Propuesta"        → 10 días sin actividad
HACER:
  1. Etiquetar "sin_actividad"
  2. Notificar al agente: "Este lead lleva X días sin contacto"
  3. Crear tarea urgente de seguimiento
  4. SI lleva 30 días sin actividad → Mover a "Archivado"
```

---

## 4.5 Automatizaciones de Cierre

### AUTO-10: Proceso de Ganado
```
CUANDO:  Deal cambia a etapa "Ganado"
HACER:
  1. Actualizar Fecha_Cierre_Real = hoy
  2. Calcular Valor_Real_Venta
  3. Crear deal en Pipeline Post-venta con mismos datos
  4. Asignar responsable de onboarding
  5. Enviar mensaje de bienvenida al cliente (via bot)
  6. Programar encuesta NPS en 15 días
  7. Notificar al equipo: "[Agente] cerró deal con [Empresa] por $[valor]"
```

### AUTO-11: Proceso de Perdido
```
CUANDO:  Deal cambia a etapa "Perdido"
HACER:
  1. Solicitar al agente que registre Motivo_Perdida (campo obligatorio)
  2. SI motivo = "Precio" → Iniciar campaña de retención en 30 días
  3. SI motivo = "Sin presupuesto" → Agendar revisión en 90 días
  4. SI motivo = "Competidor" → Registrar para análisis competitivo
  5. Enviar mensaje de cierre: "Entendemos, [Nombre]. Si en el futuro
     cambian tus planes, aquí estaremos."
  6. Mantener contacto activo (no eliminar)
```

---

## 4.6 Automatizaciones de Post-venta

### AUTO-12: Encuesta NPS Automática
```
CUANDO:  15 días después del cierre de venta
HACER:
  Bot envía: "Hola [Nombre], ¿cómo calificarías tu experiencia
  con nosotros del 0 al 10?"
  USUARIO responde número
  → Guardar en campo NPS_Score
  → SI NPS ≥ 9 → Solicitar reseña/referido
  → SI NPS 7-8 → Preguntar qué mejoraría
  → SI NPS ≤ 6 → Alerta urgente a supervisor, escalar a atención especial
```

### AUTO-13: Renovación / Upsell
```
CUANDO:  30 días antes de vencimiento de contrato (si aplica)
HACER:
  1. Notificar al agente de cuenta asignado
  2. Bot envía recordatorio amigable al cliente
  3. Crear nuevo deal de renovación en pipeline
  4. Adjuntar historial de compras para contexto
```

---

## 4.7 Resumen de Automatizaciones por Prioridad de Implementación

| Prioridad | ID | Automatización | Impacto |
|-----------|-----|---------------|---------|
| 🔴 Crítico | AUTO-01 | Creación de lead al primer mensaje | Alto |
| 🔴 Crítico | AUTO-03 | Asignación por Lead Score | Alto |
| 🔴 Crítico | AUTO-04 | SLA de respuesta | Alto |
| 🟡 Alto | AUTO-05 | Nurturing lead tibio | Alto |
| 🟡 Alto | AUTO-10 | Proceso de ganado | Alto |
| 🟡 Alto | AUTO-11 | Proceso de perdido | Medio |
| 🟢 Medio | AUTO-06 | Nurturing lead frío | Medio |
| 🟢 Medio | AUTO-09 | Detección stale deals | Medio |
| 🟢 Medio | AUTO-12 | Encuesta NPS | Medio |
| ⚪ Bajo | AUTO-02 | Deduplicación | Bajo |
| ⚪ Bajo | AUTO-13 | Renovación/Upsell | Bajo |
