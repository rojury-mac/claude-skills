# 3. Campos Personalizados Necesarios

## 3.1 Campos en CONTACTO (Contact Fields)

| Campo | Tipo | Valores / Formato | Llenado por | Requerido |
|-------|------|-------------------|-------------|-----------|
| `Canal_Origen` | Lista | WhatsApp / Instagram / Web / Referido / Otro | Bot | Sí |
| `Numero_WhatsApp` | Texto | +52XXXXXXXXXX | Bot | Sí |
| `Fecha_Primer_Contacto` | Fecha | DD/MM/AAAA HH:MM | Bot (auto) | Sí |
| `Idioma_Preferido` | Lista | Español / Inglés / Otro | Bot / Agente | No |
| `Opt_In_Marketing` | Checkbox | Sí / No | Bot (consentimiento) | Sí |
| `Etiqueta_Segmento` | Multi-lista | B2B / B2C / PYME / Corporativo | Agente | No |
| `Notas_Internas` | Texto largo | Libre | Agente | No |

---

## 3.2 Campos en LEAD/DEAL (Deal Fields)

### Datos de Calificación (llenados por el bot)

| Campo | Tipo | Valores posibles | Llenado por |
|-------|------|-----------------|-------------|
| `Necesidad_Principal` | Texto largo | Respuesta libre del usuario | Bot |
| `Urgencia` | Lista | Esta semana / Este mes / 3 meses / Explorando | Bot |
| `Rango_Presupuesto` | Lista | < $X / $X–$Y / > $Y / Sin definir | Bot |
| `Rol_Decisor` | Lista | Decisor único / Parte del equipo / Necesita aprobación | Bot |
| `Lead_Score` | Número | 0–10 | Bot (calculado) |
| `Temperatura_Lead` | Lista | 🔴 Caliente / 🟡 Tibio / 🔵 Frío | Bot (auto) |

### Datos de Seguimiento (llenados por agente / sistema)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `Agente_Asignado` | Usuario | Vendedor responsable |
| `Fecha_Ultimo_Contacto` | Fecha | Actualizado en cada interacción |
| `Proximo_Seguimiento` | Fecha | Fecha de la próxima acción programada |
| `Motivo_Perdida` | Lista | Precio / Competidor / Sin presupuesto / No interesado / Sin respuesta |
| `Motivo_Cancelacion` | Lista | Precio / Problema técnico / No usa el servicio / Otro |
| `Fuente_Lead` | Lista | Facebook Ads / Google / Referido / Orgánico / Email / Evento |
| `Campana_Origen` | Texto | Nombre/ID de la campaña de marketing |
| `Intentos_Contacto` | Número | Contador de intentos fallidos de contacto |
| `Valor_Potencial` | Moneda | Estimado del deal en $MXN / $USD |

### Datos Post-venta

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `Fecha_Cierre_Real` | Fecha | Cuando se cerró la venta |
| `Producto_Contratado` | Multi-lista | Productos/servicios específicos comprados |
| `Valor_Real_Venta` | Moneda | Monto final pagado |
| `Responsable_Onboarding` | Usuario | Quién hace la entrega/implementación |
| `NPS_Score` | Número | 0–10, resultado de encuesta de satisfacción |

---

## 3.3 Etiquetas (Tags) del Sistema

### Etiquetas de Estado del Bot
```
bot_activo          → Conversación en curso con el bot
bot_completado      → Calificación finalizada
bot_abandonado      → Usuario dejó de responder mid-flujo
escalado            → Transferido a humano
```

### Etiquetas de Clasificación
```
nurturing_activo    → En secuencia de nurturing
lead_frio           → Score bajo, seguimiento lejano
riesgo_cancelacion  → En proceso de retención
vip                 → Cliente de alto valor
```

### Etiquetas de Canal
```
whatsapp            → Vía WhatsApp Business
instagram_dm        → Vía Instagram Direct
webchat             → Vía widget en sitio web
llamada_entrante    → Originado por llamada
```

---

## 3.4 Lógica de Lead Score (Cálculo)

```
LEAD SCORE = Urgencia + Presupuesto + Rol + Canal + Respuesta

Urgencia:
  Esta semana    = 3 puntos
  Este mes       = 2 puntos
  3 meses        = 1 punto
  Explorando     = 0 puntos

Presupuesto:
  > $Y (alto)    = 3 puntos
  $X–$Y (medio)  = 2 puntos
  < $X (bajo)    = 1 punto
  Sin definir    = 0 puntos

Rol Decisor:
  Decisor único  = 2 puntos
  Parte del equipo = 1 punto
  Necesita aprobación = 0 puntos

Velocidad de respuesta:
  Responde en < 5 min  = 1 punto
  Responde en 5–30 min = 0 puntos

CLASIFICACIÓN:
  8–9 puntos → 🔴 Caliente (transferir de inmediato)
  5–7 puntos → 🟡 Tibio (seguimiento en 24h)
  0–4 puntos → 🔵 Frío (nurturing automatizado)
```

---

## 3.5 Campos de Configuración del Bot (en settings/metadatos)

Estos no son campos de CRM sino configuración del comportamiento del bot:

| Parámetro | Valor sugerido | Descripción |
|-----------|---------------|-------------|
| `timeout_respuesta_min` | 10 | Minutos antes de enviar recordatorio |
| `timeout_abandono_horas` | 24 | Horas antes de marcar como abandonado |
| `max_reintentos_faq` | 3 | Intentos antes de escalar a humano |
| `horario_atencion_inicio` | 09:00 | Hora inicio de atención humana |
| `horario_atencion_fin` | 18:00 | Hora fin de atención humana |
| `mensaje_fuera_horario` | texto | Mensaje cuando está fuera de horario |
| `agente_default_escalado` | user_id | Agente receptor cuando no hay asignación |
