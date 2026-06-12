# Kondorito Postres y Pasteles

Plataforma web para Kondorito Postres y Pasteles, desarrollada como proyecto final universitario. El sistema permite a los clientes consultar el catálogo, gestionar un carrito de compras, realizar pedidos, pagar en línea, revisar su historial y hacer seguimiento de entregas en tiempo real.

## Demo en producción

- Web principal: https://kondorito.onrender.com/
- Servicio de tracking / PWA domiciliarios: https://kondorito-tracking.onrender.com/

## Descripción general

Kondorito es una plataforma de gestión de pedidos para una pastelería. Incluye sitio web para clientes, autenticación de usuarios, catálogo de productos, carrito de compras, pagos en línea, registro de pedidos, panel administrativo, gestión de inventario, asignación de domiciliarios y tracking en tiempo real.

La aplicación web principal está desarrollada en PHP y desplegada en Render mediante Docker. La información se almacena en Supabase PostgreSQL y los pagos se procesan mediante Stripe Checkout. El seguimiento en tiempo real se maneja mediante un servicio independiente desarrollado con Node.js y Socket.IO.

## Funcionalidades principales

### Cliente
- Página principal responsive.
- Catálogo completo de productos.
- Personalización de productos antes de agregarlos al carrito.
- Registro e inicio de sesión.
- Configuración de perfil.
- Carrito persistente por usuario.
- Página de pago con datos de entrega.
- Selección exacta de ubicación de entrega mediante mapa.
- Flujo de pago con Stripe Checkout.
- Creación del pedido después del pago exitoso.
- Historial y pedidos en curso desde `mis_pedidos.php`.
- Mapa de tracking en tiempo real para pedidos asignados.

### Administrador
- Inicio de sesión administrativo.
- Panel administrativo.
- Gestión de pedidos.
- Cambio de estados de pedidos.
- Asignación de domiciliarios.
- Gestión de inventario.
- Control de productos disponibles.
- Monitoreo de domiciliarios en tiempo real mediante mapa.

### Tracking
- Integración con servicio externo de tracking.
- Conexión de domiciliarios desde PWA.
- Ubicación GPS en tiempo real.
- Monitoreo de domiciliarios desde el panel administrativo.
- Seguimiento del pedido desde la vista del cliente.
- Mapas con Leaflet y OpenStreetMap.

## Tecnologías utilizadas

### Aplicación principal
- PHP
- HTML5
- CSS3
- JavaScript
- Tailwind CSS
- Font Awesome

### Base de datos
- Supabase PostgreSQL
- PDO con consultas preparadas

### Pagos
- Stripe Checkout

### Mapas y ubicación
- Leaflet
- OpenStreetMap
- Browser Geolocation API

### Servicio de tracking
- Node.js
- Express
- Socket.IO
- OSRM API
- Nominatim API

### Despliegue
- Render
- Docker
- Variables de entorno

## Arquitectura

El proyecto está dividido en dos servicios principales:

1. **Aplicación web principal de Kondorito**
   - Gestiona usuarios, catálogo, carrito, pagos, pedidos, panel administrativo e inventario.
   - Está desarrollada en PHP.
   - Se conecta a Supabase PostgreSQL.
   - Está desplegada en Render mediante Docker.

2. **Servicio de tracking**
   - Gestiona la conexión de domiciliarios y la ubicación en tiempo real.
   - Está desarrollado con Node.js y Socket.IO.
   - Proporciona la PWA para domiciliarios.
   - Se comunica con la web principal mediante asignación de pedidos y eventos en tiempo real.

## Flujo principal

1. El cliente se registra o inicia sesión.
2. Consulta el catálogo y agrega productos al carrito.
3. Completa los datos de entrega y selecciona la ubicación exacta en el mapa.
4. Realiza el pago mediante Stripe Checkout.
5. Después del pago exitoso, el pedido se guarda en Supabase PostgreSQL.
6. El administrador revisa el pedido y asigna un domiciliario.
7. El domiciliario recibe el pedido en la PWA.
8. El domiciliario comparte su ubicación GPS en tiempo real.
9. El administrador y el cliente pueden seguir la entrega desde el mapa.

## Medidas de seguridad

- Uso de variables de entorno para credenciales sensibles.
- Archivo `.env` excluido del repositorio.
- Consultas preparadas con PDO para reducir riesgo de SQL Injection.
- Contraseñas protegidas mediante hash.
- Control de acceso mediante sesiones.
- Pagos gestionados mediante Stripe Checkout.
- Estructura con carpeta `public` para exponer solo archivos necesarios.
- Base de datos en la nube mediante Supabase PostgreSQL.
