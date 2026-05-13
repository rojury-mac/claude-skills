# 1. Estructura del CRM en Kommo

## 1.1 Pipeline Principal — Ciclo de Vida del Lead

```
[NUEVO CONTACTO]
      │
      ▼
┌─────────────────┐
│  1. ENTRADA     │  ← Bot recibe mensaje inicial
│  (Nuevo Lead)   │     Canal: WhatsApp / Instagram / Web Chat
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  2. CALIFICACIÓN│  ← Bot ejecuta flujo de preguntas
│  (Bot activo)   │     Recopila: nombre, necesidad, presupuesto
└────────┬────────┘
         │
    ┌────┴────┐
    │         │
[Calificado] [No calificado]
    │              │
    ▼              ▼
┌────────┐   ┌──────────┐
│ 3. CON-│   │ NURTURING│ ← Secuencia automatizada
│ TACTO  │   │ (90 días)│    emails + mensajes
│HUMANO  │   └──────────┘
└───┬────┘
    │
    ▼
┌─────────────────┐
│  4. PROPUESTA   │  ← Agente asignado manualmente
│  (Negociación)  │
└────────┬────────┘
         │
    ┌────┴────┐
    │         │
[Ganado]   [Perdido]
    │           │
    ▼           ▼
┌────────┐  ┌────────┐
│ 5.POST-│  │ 6.ARCH-│
│  VENTA │  │ IVADO  │
└────────┘  └────────┘
```

## 1.2 Definición de Etapas

| # | Etapa | Responsable | SLA máximo | Condición de avance |
|---|-------|-------------|------------|---------------------|
| 1 | Entrada | Bot | 0 min | Mensaje recibido |
| 2 | Calificación | Bot | 10 min | Flujo completado |
| 3 | Contacto Humano | Agente | 2 horas | Lead score ≥ 60 |
| 4 | Propuesta | Agente | 48 horas | Propuesta enviada |
| 5 | Post-venta | CS | 24 horas | Pago confirmado |
| 6 | Archivado | Sistema | Automático | Sin actividad 90 días |

## 1.3 Pipelines Secundarios (recomendados)

### Pipeline de Soporte / Postventa
```
Ticket recibido → Triaje (Bot) → En atención → Resuelto → Cerrado
```

### Pipeline de Recuperación (Leads Perdidos)
```
Archivado → Reactivación (campaña) → Re-calificación → Pipeline principal
```

## 1.4 Estructura de Contactos y Empresas

```
EMPRESA (Company)
├── Nombre comercial
├── RFC / Identificación fiscal
├── Industria
├── Tamaño (empleados)
└── CONTACTOS asociados (1..N)
    ├── Contacto principal (decision maker)
    ├── Contacto técnico
    └── Contacto financiero

LEAD / DEAL
├── Vinculado a: Contacto + Empresa
├── Pipeline asignado
├── Valor estimado
└── Campos personalizados (ver sección 3)
```

## 1.5 Segmentación de Usuarios del CRM

| Rol | Acceso | Descripción |
|-----|--------|-------------|
| Admin | Total | Configura pipelines, automatizaciones, integraciones |
| Supervisor | Reportes + todos los leads | Monitorea KPIs del equipo |
| Agente de Ventas | Solo sus leads asignados | Gestiona negociaciones |
| Agente de Soporte | Pipeline soporte | Atiende tickets postventa |
| Bot (API user) | Escritura + creación | Crea/actualiza leads y notas |
