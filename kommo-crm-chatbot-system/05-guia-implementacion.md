# 5. Guía de Implementación Paso a Paso

## Prerrequisitos

- Cuenta de Kommo (plan Advanced o superior para automatizaciones completas)
- Número de WhatsApp Business verificado (Meta Business Suite)
- Acceso de administrador en Kommo
- Definición del alcance: ¿Qué productos/servicios atiende el bot?

---

## FASE 1 — Configuración Base de Kommo (Días 1–3)

### Paso 1.1 — Crear el Pipeline Principal

1. Ir a `Configuración → Pipelines → + Nuevo Pipeline`
2. Nombrar: `"Pipeline Ventas"`
3. Crear las etapas en orden:
   - `Entrada` (color gris)
   - `Calificación` (color azul)
   - `Contacto Humano` (color naranja)
   - `Propuesta` (color amarillo)
   - `Ganado` (color verde — etapa de éxito)
   - `Perdido` (color rojo — etapa de fracaso)
4. Guardar pipeline.

### Paso 1.2 — Crear el Pipeline de Post-venta

1. `+ Nuevo Pipeline` → Nombrar: `"Post-venta / Onboarding"`
2. Etapas:
   - `Bienvenida`
   - `Onboarding en curso`
   - `Activo / Satisfecho`
   - `En riesgo` (para leads con NPS bajo)
3. Guardar.

### Paso 1.3 — Crear el Pipeline de Soporte

1. `+ Nuevo Pipeline` → Nombrar: `"Soporte Técnico"`
2. Etapas:
   - `Ticket Nuevo`
   - `En Investigación`
   - `Esperando Cliente`
   - `Resuelto`
   - `Cerrado`
3. Guardar.

---

## FASE 2 — Campos Personalizados (Día 3–4)

### Paso 2.1 — Crear campos en Contactos

1. Ir a `Configuración → Campos → Contactos`
2. Agregar cada campo de la sección 3.1:

   ```
   + Canal_Origen         → Tipo: Lista desplegable
   + Numero_WhatsApp      → Tipo: Teléfono
   + Fecha_Primer_Contacto → Tipo: Fecha y hora
   + Opt_In_Marketing     → Tipo: Casilla de verificación
   + Etiqueta_Segmento    → Tipo: Multi-lista
   ```

### Paso 2.2 — Crear campos en Deals

1. Ir a `Configuración → Campos → Deals`
2. Agregar campos de calificación (sección 3.2):

   ```
   + Necesidad_Principal  → Tipo: Texto largo
   + Urgencia             → Tipo: Lista (opciones: Esta semana / Este mes / 3 meses / Explorando)
   + Rango_Presupuesto    → Tipo: Lista (opciones: configurar según precios propios)
   + Rol_Decisor          → Tipo: Lista
   + Lead_Score           → Tipo: Número (0-10)
   + Temperatura_Lead     → Tipo: Lista (Caliente / Tibio / Frío)
   + Fuente_Lead          → Tipo: Lista
   + Motivo_Perdida       → Tipo: Lista
   + Valor_Potencial      → Tipo: Moneda
   ```

### Paso 2.3 — Configurar Etiquetas del Sistema

1. Ir a `Configuración → Etiquetas`
2. Crear cada etiqueta de la sección 3.3 con los colores correspondientes:
   - Rojo: `escalado`, `riesgo_cancelacion`
   - Naranja: `bot_activo`, `nurturing_activo`
   - Verde: `bot_completado`, `vip`
   - Gris: `bot_abandonado`, `lead_frio`, `sin_actividad`

---

## FASE 3 — Integración de Canales (Días 4–6)

### Paso 3.1 — Conectar WhatsApp Business

1. Ir a `Configuración → Integraciones → WhatsApp Business`
2. Click en `Conectar vía Meta`
3. Autorizar con cuenta de Meta Business Suite
4. Seleccionar número de WhatsApp Business verificado
5. Asignar el pipeline: `Pipeline Ventas`
6. Configurar: mensajes entrantes → crear lead automáticamente

   > **Nota:** Kommo requiere WhatsApp Business API (no la app normal). Si usas un proveedor como Twilio, 360dialog o Wati, la integración va por `Configuración → API e Integraciones`.

### Paso 3.2 — Conectar Instagram Direct (opcional)

1. `Configuración → Integraciones → Instagram`
2. Conectar con Facebook Business Manager
3. Seleccionar página/cuenta de Instagram
4. Misma configuración: mensajes entrantes → nuevo lead

### Paso 3.3 — Instalar Widget de Chat en Sitio Web (opcional)

1. `Configuración → Widget de Chat`
2. Personalizar colores y texto de bienvenida
3. Copiar el código JS generado
4. Pegar en el `<head>` del sitio web (antes de `</head>`)

---

## FASE 4 — Configuración del Bot (Salesbot) (Días 6–10)

### Paso 4.1 — Crear Salesbot de Bienvenida y Calificación

1. Ir a `Configuración → Salesbots → + Nuevo Salesbot`
2. Nombrar: `"Bot Calificación v1"`
3. Construir el flujo usando el editor visual:

   **Bloque 1 — Saludo:**
   ```
   Tipo: Enviar mensaje
   Texto: "¡Hola! Soy [Nombre Bot] de [Empresa]. ¿Con quién tengo el gusto?"
   Esperar respuesta: Sí
   Guardar respuesta en: Contacto > Nombre
   ```

   **Bloque 2 — Menú Principal:**
   ```
   Tipo: Botones de respuesta rápida
   Texto: "¿En qué te puedo ayudar?"
   Opciones:
     [Información de servicios]  → Rama A
     [Cotización / Precios]      → Rama B
     [Soporte técnico]           → Rama C
     [Hablar con un asesor]      → Rama D
   ```

   **Rama B — Calificación (ejemplo):**
   ```
   Bloque: "¿Qué problema necesitas resolver?"
     Esperar: respuesta libre
     Guardar en: Deal > Necesidad_Principal

   Bloque: "¿Cuándo necesitas la solución?"
     Botones: [Esta semana] [Este mes] [3 meses] [Explorando]
     Guardar en: Deal > Urgencia

   Bloque: "¿Tienes presupuesto definido?"
     Botones: [Sí, menos de $X] [Sí, $X-$Y] [Sí, más de $Y] [No definido]
     Guardar en: Deal > Rango_Presupuesto

   Bloque: "¿Eres quien tomará la decisión?"
     Botones: [Sí, soy el decisor] [Soy parte del equipo] [Necesito aprobación]
     Guardar en: Deal > Rol_Decisor

   Bloque final: Calcular Lead Score (fórmula) → Actualizar Temperatura_Lead
   ```

4. Configurar condición de fin:
   - Si Lead Score ≥ 8 → Rama "Transferir a humano"
   - Si Lead Score 5–7 → Rama "Programar seguimiento"
   - Si Lead Score < 5 → Rama "Nurturing"

### Paso 4.2 — Crear Salesbot de Soporte

1. `+ Nuevo Salesbot` → Nombrar: `"Bot Soporte"`
2. Construir según Flujo 3 (sección 2.3 del documento de flujos)
3. Integrar con Pipeline de Soporte Técnico

### Paso 4.3 — Crear Salesbot de Retención

1. `+ Nuevo Salesbot` → Nombrar: `"Bot Retención"`
2. Construir según Flujo 5 (sección 2.5 del documento de flujos)
3. Trigger: palabras clave detectadas

### Paso 4.4 — Configurar Detección de Palabras Clave

1. En cada Salesbot, activar la opción `Detectar palabras clave`
2. Agregar las palabras del mapa de intenciones (sección 2.4)
3. Mapear cada grupo de palabras al bot correspondiente

---

## FASE 5 — Automatizaciones (Días 10–14)

### Paso 5.1 — Crear Automatización AUTO-01 (más crítica)

1. `Configuración → Automatizaciones → + Nueva automatización`
2. Nombrar: `"Creación de Lead al Primer Mensaje"`
3. Configurar trigger:
   - `Evento: Mensaje entrante`
   - `Condición: Contacto sin deal activo`
4. Configurar acciones en orden:
   - `Crear deal` en Pipeline Ventas, etapa "Entrada"
   - `Establecer campo` Canal_Origen = [variable: canal del mensaje]
   - `Establecer campo` Fecha_Primer_Contacto = [ahora]
   - `Agregar etiqueta`: bot_activo
   - `Iniciar Salesbot`: Bot Calificación v1
5. Guardar y activar.

### Paso 5.2 — Crear Automatización AUTO-03 (Asignación por Score)

1. `+ Nueva automatización` → Nombrar: `"Asignación por Lead Score"`
2. Trigger: `Campo Lead_Score es actualizado`
3. Ramas condicionales:
   ```
   SI Lead_Score ≥ 8:
     Acción 1: Cambiar Temperatura_Lead = "Caliente"
     Acción 2: Cambiar etapa = "Contacto Humano"
     Acción 3: Asignar responsable (round-robin: Grupo Senior)
     Acción 4: Crear tarea "Contactar URGENTE" vence en 1 hora
     Acción 5: Notificación push al responsable

   SINO SI Lead_Score ≥ 5:
     [acciones para tibio...]

   SINO:
     [acciones para frío...]
   ```

### Paso 5.3 — Crear Automatizaciones SLA

1. Crear AUTO-04 para alertas de demora
2. Crear AUTO-09 para stale deals
3. Configurar los tiempos según los SLA definidos en sección 1.2

### Paso 5.4 — Crear Secuencias de Nurturing

1. Para AUTO-05 y AUTO-06, usar la función `Secuencia de mensajes` en Salesbots
2. Configurar los delays de días entre mensajes
3. Activar condición de pausa: si el lead responde, pausar la secuencia

---

## FASE 6 — Roles y Permisos (Día 14–15)

### Paso 6.1 — Configurar Roles

1. `Configuración → Usuarios y Equipos → Roles`
2. Crear/ajustar roles según sección 1.5
3. Asignar permisos:

   | Rol | Permisos clave |
   |-----|----------------|
   | Admin | Todo |
   | Supervisor | Ver todos los deals, reportes, reasignar |
   | Agente Ventas | Ver/editar solo sus deals, crear contactos |
   | Agente Soporte | Solo pipeline de soporte |

### Paso 6.2 — Crear Grupos de Usuarios

1. `Configuración → Usuarios y Equipos → Equipos`
2. Crear: `"Ventas Senior"`, `"Ventas Junior"`, `"Soporte"`
3. Asignar usuarios a cada grupo
4. Configurar round-robin en las automatizaciones de asignación

---

## FASE 7 — Pruebas (Días 15–18)

### Paso 7.1 — Pruebas del Bot (checklist)

```
□ Enviar mensaje inicial → ¿Se crea el deal? ¿Arranca el bot?
□ Completar flujo de calificación → ¿Se guardan los campos?
□ Verificar Lead Score calculado → ¿Es correcto?
□ Probar cada opción del menú → ¿Redirige al flujo correcto?
□ No responder 10 minutos → ¿Llega recordatorio?
□ No responder 24 horas → ¿Se marca como abandonado?
□ Escribir "cancelar" → ¿Activa bot de retención?
□ Escribir "hablar con asesor" → ¿Transfiere inmediatamente?
□ Enviar 3 mensajes incomprensibles → ¿Escala a humano?
□ Probar fuera de horario → ¿Responde correctamente?
```

### Paso 7.2 — Pruebas de Automatizaciones

```
□ AUTO-01: Primer mensaje → Lead creado correctamente
□ AUTO-03: Cambiar Lead Score a 8 → ¿Se asigna agente y cambia etapa?
□ AUTO-04: Dejar lead sin actividad 1 hora → ¿Llega alerta?
□ AUTO-09: Dejar lead 5 días sin actividad → ¿Se etiqueta?
□ AUTO-10: Mover a "Ganado" → ¿Se crea deal en post-venta?
□ AUTO-11: Mover a "Perdido" → ¿Solicita motivo?
```

### Paso 7.3 — Prueba de Integración WhatsApp

```
□ Enviar mensaje real desde WhatsApp → ¿Aparece en Kommo?
□ Responder desde Kommo → ¿Llega al WhatsApp del usuario?
□ Los botones del bot → ¿Se muestran como botones en WhatsApp?
□ Variables (nombre, etc.) → ¿Se reemplazan correctamente?
```

---

## FASE 8 — Capacitación del Equipo (Días 18–20)

### Agenda de Capacitación

**Sesión 1 (2h) — Para Agentes de Ventas:**
- Navegación básica de Kommo
- Gestión de leads asignados
- Cómo registrar notas y actividades
- Cómo completar campos de calificación
- Transferencia de/hacia el bot

**Sesión 2 (1h) — Para Supervisores:**
- Dashboard y reportes
- Reasignación de leads
- Interpretación del Lead Score
- Gestión de alertas SLA

**Sesión 3 (30 min) — Para Administrador:**
- Edición de automatizaciones
- Actualización de mensajes del bot
- Gestión de usuarios y permisos

---

## FASE 9 — Go Live y Monitoreo (Días 20+)

### Día 1 post-lanzamiento: monitorear cada hora
- ¿Los leads entran correctamente?
- ¿El bot responde sin errores?
- ¿Las asignaciones son correctas?

### Primera semana: revisión diaria
- Tasa de abandono del bot (objetivo: < 30%)
- Tiempo promedio de respuesta humana (objetivo: < 2 horas)
- Lead Score promedio (referencia inicial)

### KPIs para reportes semanales

| KPI | Fórmula | Objetivo inicial |
|-----|---------|-----------------|
| Tasa de calificación | Leads calificados / Leads entrantes | > 60% |
| Tiempo de 1er respuesta | Promedio minutos hasta 1er contacto humano | < 30 min |
| Tasa de conversión | Deals ganados / Leads calificados | Baseline mes 1 |
| Abandono del bot | Leads bot_abandonado / bot_activo | < 30% |
| Lead Score promedio | Promedio del campo Lead_Score | Baseline mes 1 |
| NPS promedio | Promedio campo NPS_Score | > 7 |

---

## Checklist Final de Go-Live

```
□ Pipeline principal creado con todas las etapas
□ Pipelines secundarios creados
□ Todos los campos personalizados creados
□ Etiquetas configuradas
□ WhatsApp Business integrado y probado
□ Bot de calificación construido y probado
□ Bot de soporte construido
□ Bot de retención construido
□ Automatizaciones críticas activas (AUTO-01, 03, 04)
□ Usuarios y roles configurados
□ Grupos de round-robin configurados
□ Equipo capacitado
□ Dashboard de supervisión configurado
□ Documento de preguntas frecuentes del bot actualizado
□ Plan de contingencia si el bot falla (modo solo humanos)
```
