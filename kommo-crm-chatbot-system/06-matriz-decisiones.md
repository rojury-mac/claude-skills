# 6. Matriz de Decisiones y Referencia Rápida

## 6.1 ¿Cuándo interviene el bot vs. el humano?

```
┌─────────────────────────────────┬──────────┬──────────┐
│ Situación                       │  Bot     │  Humano  │
├─────────────────────────────────┼──────────┼──────────┤
│ Primer mensaje entrante         │   ✅     │          │
│ Calificación inicial            │   ✅     │          │
│ Preguntas frecuentes (FAQ)      │   ✅     │          │
│ Fuera de horario laboral        │   ✅     │          │
│ Lead Score ≥ 8                  │          │   ✅     │
│ Usuario pide hablar con humano  │          │   ✅     │
│ 3+ respuestas incomprensibles   │          │   ✅     │
│ Señal de cancelación/retención  │   ✅ *   │   ✅ **  │
│ Negociación de precio           │          │   ✅     │
│ Cierre de venta                 │          │   ✅     │
│ Queja escalada                  │          │   ✅     │
│ Seguimiento de nurturing        │   ✅     │          │
│ Soporte técnico nivel 1 (FAQ)   │   ✅     │          │
│ Soporte técnico nivel 2+        │          │   ✅     │
└─────────────────────────────────┴──────────┴──────────┘
* Bot inicia la retención, intenta resolver
** Humano toma control si el bot no resuelve en 1 respuesta
```

---

## 6.2 Árbol de Prioridad de Flujos

```
MENSAJE ENTRANTE
       │
       ├─ ¿Es cliente con ticket activo?
       │      └─ SÍ → Bot Soporte
       │
       ├─ ¿Contiene palabra de cancelación?
       │      └─ SÍ → Bot Retención (prioridad alta)
       │
       ├─ ¿Solicita hablar con humano?
       │      └─ SÍ → Transferencia directa (sin pasos)
       │
       ├─ ¿Es primer contacto?
       │      └─ SÍ → Bot Bienvenida + Calificación
       │
       └─ ¿Es contacto existente en nurturing?
              └─ SÍ → Responder en contexto de nurturing
```

---

## 6.3 Variables de Kommo para Mensajes del Bot

Usar estas variables en los mensajes del Salesbot:

| Variable Kommo | Contenido |
|----------------|-----------|
| `{{contact.name}}` | Nombre del contacto |
| `{{contact.phone}}` | Teléfono |
| `{{deal.name}}` | Nombre del deal |
| `{{deal.price}}` | Valor del deal |
| `{{user.name}}` | Nombre del agente asignado |
| `{{user.phone}}` | Teléfono del agente |
| `{{company.name}}` | Nombre de tu empresa |

---

## 6.4 Plantillas de Mensajes Clave

### Bienvenida inicial
```
¡Hola! Soy [Bot] de {{company.name}}. ¿Con quién tengo el gusto?
```

### Transferencia a humano
```
¡Perfecto, {{contact.name}}! Te voy a conectar con {{user.name}},
quien te atenderá en breve. ¿Hay algo más que quieras que le comunique?
```

### Fuera de horario
```
Hola {{contact.name}}, gracias por escribirnos. Nuestro horario de
atención es de 9:00 a 18:00 hrs. Mañana a primera hora un asesor
se pondrá en contacto contigo. ¡Hasta pronto!
```

### Recordatorio de seguimiento
```
Hola {{contact.name}}, hace unos días hablamos sobre [tema].
¿Tuviste oportunidad de revisarlo? Estoy aquí si tienes dudas.
```

### Cierre sin interés
```
Entendemos perfectamente, {{contact.name}}. Si en el futuro
necesitas [solución], aquí estaremos. ¡Hasta pronto y mucho éxito!
```

---

## 6.5 Errores Comunes y Cómo Evitarlos

| Error común | Causa | Solución |
|-------------|-------|----------|
| Bot no inicia al recibir mensaje | Auto-01 inactiva o mal configurada | Verificar trigger y condición |
| Campos del bot no se guardan | Variable de campo mal escrita | Revisar nombre exacto del campo en Kommo |
| Lead Score siempre 0 | Fórmula de cálculo no configurada | Usar campo calculado o automatización |
| Bot responde aunque ya hay humano | No hay condición "bot inactivo si agente tomó control" | Agregar condición de pausa al salesbot |
| Mensajes duplicados | Dos salesbots activos al mismo tiempo | Verificar que solo un bot esté asignado por pipeline |
| WhatsApp no entrega mensajes | Plantilla no aprobada por Meta | Usar solo plantillas aprobadas para mensajes salientes |
| Round-robin no funciona | Grupo de usuarios vacío | Verificar que el grupo tenga usuarios activos asignados |

---

## 6.6 Glosario

| Término | Definición en este sistema |
|---------|--------------------------|
| **Salesbot** | Nombre de Kommo para los flujos de chatbot |
| **Deal** | Negocio/oportunidad vinculada a un contacto |
| **Pipeline** | Embudo de ventas con etapas secuenciales |
| **Lead Score** | Puntuación de calidad del lead (0–10) |
| **Temperatura** | Clasificación Caliente/Tibio/Frío según score |
| **Nurturing** | Secuencia automatizada de mensajes para leads tibios/fríos |
| **SLA** | Acuerdo de nivel de servicio — tiempo máximo para responder |
| **Round-robin** | Asignación rotativa equitativa entre agentes |
| **Escalado** | Transferencia del bot a un agente humano |
| **Stale deal** | Deal sin actividad por un tiempo definido |
| **Trigger** | Evento que activa una automatización |
| **Opt-in** | Consentimiento del usuario para recibir mensajes |
