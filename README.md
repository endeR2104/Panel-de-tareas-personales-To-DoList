# 📋 Panel de Tareas Personales (To-Do List con Usuarios)

![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Status](https://img.shields.io/badge/Status-Completado-brightgreen?style=for-the-badge)

> **Aplicación web completa de gestión de tareas con autenticación de usuarios, diseñada para aprender y practicar PHP, MySQL, y desarrollo full-stack.**

---

## 📖 Descripción

**Panel de Tareas Personales** es una aplicación web tipo **To-Do List** que permite a los usuarios registrarse, iniciar sesión y gestionar sus propias tareas de forma segura y privada. Cada usuario tiene su propio espacio donde puede:

- ✅ Crear tareas con título, descripción, fecha límite y prioridad.
- ✏️ Editar tareas existentes.
- ✔️ Marcar tareas como completadas o reabrirlas.
- 🗑️ Eliminar tareas (con confirmación previa).
- 🔍 Filtrar tareas por estado (pendientes / completadas).
- 📱 Acceder desde cualquier dispositivo gracias al diseño responsive.

El proyecto fue desarrollado con **PHP nativo** (sin frameworks), **MySQL** para la base de datos, **Bootstrap 5** para el frontend y **JavaScript** para validaciones básicas. Es ideal para portafolios, prácticas académicas o como base para proyectos más complejos.

---

## 🎯 Características Principales

### 🔐 Autenticación y Seguridad
- Registro de nuevos usuarios con validación de campos.
- Inicio de sesión con sesiones PHP.
- Contraseñas almacenadas con **hash seguro** (`password_hash`).
- Protección de rutas: solo usuarios autenticados pueden acceder al dashboard.
- Cada usuario solo visualiza y gestiona **sus propias tareas**.

### 📋 Gestión de Tareas
- **Crear tarea**: Título (obligatorio), descripción, fecha límite, prioridad (alta/media/baja).
- **Editar tarea**: Modificar cualquier campo de una tarea existente.
- **Cambiar estado**: Marcar como completada o reabrir con un solo clic.
- **Eliminar tarea**: Confirmación con JavaScript antes de borrar.
- **Filtros**: Ver solo tareas pendientes o completadas.

### 🎨 Diseño y Experiencia de Usuario
- **Responsive**: Se adapta a móviles, tablets y escritorios.
- **Interfaz intuitiva**: Colores según prioridad (rojo = alta, amarillo = media, verde = baja).
- **Feedback visual**: Mensajes de éxito/error tras cada acción.
- **Iconos**: Uso de Bootstrap Icons para una mejor experiencia.

### 🛡️ Validaciones
- **Frontend**: JavaScript valida campos vacíos y confirma eliminaciones.
- **Backend**: PHP valida y sanitiza todas las entradas.

---

## 🛠️ Tecnologías Utilizadas

| Tecnología | Versión | Propósito |
|------------|---------|-----------|
| **PHP** | 7.4+ | Lógica del servidor, sesiones, interacción con BD |
| **MySQL** | 5.7+ | Almacenamiento de usuarios y tareas |
| **Bootstrap** | 5.3 | Diseño responsive y componentes UI |
| **JavaScript** | ES6 | Validaciones en frontend y confirmaciones |
| **PDO** | - | Conexión segura a la base de datos |
| **HTML5 / CSS3** | - | Estructura y estilos personalizados |

---

## 📂 Estructura del Proyecto

```
todolist/
│
├── config.php               # Configuración de BD y sesiones
├── register.php             # Registro de nuevos usuarios
├── login.php                # Inicio de sesión
├── dashboard.php            # Panel principal (lista de tareas)
├── create_task.php          # Crear nueva tarea
├── edit_task.php            # Editar tarea existente
├── delete_task.php          # Eliminar tarea
├── toggle_status.php        # Cambiar estado (pendiente/completada)
├── logout.php               # Cerrar sesión
├── style.css                # Estilos personalizados (opcional)
└── README.md                # Este archivo
```

---

## 🗄️ Esquema de la Base de Datos

### Tabla `users`
| Campo      | Tipo         | Descripción |
|------------|--------------|-------------|
| `id`       | INT (PK)     | ID único del usuario |
| `username` | VARCHAR(50)  | Nombre de usuario (único) |
| `password` | VARCHAR(255) | Contraseña hasheada |
| `created_at`| TIMESTAMP   | Fecha de registro |

### Tabla `tasks`
| Campo         | Tipo                    | Descripción |
|---------------|-------------------------|-------------|
| `id`          | INT (PK)                | ID único de la tarea |
| `user_id`     | INT (FK)                | ID del usuario propietario |
| `title`       | VARCHAR(100)            | Título de la tarea |
| `description` | TEXT                    | Descripción detallada |
| `due_date`    | DATE                    | Fecha límite (opcional) |
| `priority`    | ENUM('low','medium','high') | Prioridad |
| `status`      | ENUM('pending','completed') | Estado actual |
| `created_at`  | TIMESTAMP               | Fecha de creación |

---

## 💻 Instalación y Configuración

### Requisitos Previos
- [XAMPP](https://www.apachefriends.org/) o [MAMP](https://www.mamp.info/) (para entorno local)
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Navegador web moderno

### Pasos para Instalación Local

1. **Clona el repositorio**
   ```bash
   git clone https://github.com/endeR2104/Panel-de-tareas-personales.git
   ```

2. **Mueve los archivos a tu servidor local**
   - Si usas XAMPP: Copia la carpeta en `htdocs/`
   - Si usas MAMP: Copia en `htdocs/`

3. **Crea la base de datos**
   - Abre phpMyAdmin: `http://localhost/phpmyadmin`
   - Ejecuta el script SQL proporcionado en el repositorio.

4. **Configura la conexión**
   - Abre `config.php`
   - Ajusta los datos de conexión:
     ```php
     $host = 'localhost';
     $dbname = 'todo_db';
     $username = 'root';
     $password = '';
     ```

5. **Accede al proyecto**
   - Abre tu navegador y ve a: `http://localhost/todolist/register.php`

6. **¡Regístrate y comienza a usar la aplicación!**

---

## 🌐 Despliegue en Hosting Gratuito

### Opción 1: InfinityFree
1. Crea una cuenta en [InfinityFree](https://www.infinityfree.com/).
2. Crea un sitio web y obtén tus credenciales FTP.
3. Crea una base de datos MySQL desde el panel de control.
4. Importa el script SQL.
5. Sube todos los archivos vía FTP.
6. Modifica `config.php` con los datos de tu hosting.

### Opción 2: 000webhost
1. Regístrate en [000webhost](https://www.000webhost.com/).
2. Crea un sitio y accede al panel de control.
3. Sube los archivos usando el administrador de archivos.
4. Crea la base de datos desde phpMyAdmin.
5. Actualiza `config.php` con las credenciales.

---

## 🧪 Pruebas y Uso

### Flujo Básico
1. **Regístrate** con un nombre de usuario y contraseña.
2. **Inicia sesión** con tus credenciales.
3. Desde el **dashboard**, crea tu primera tarea.
4. **Gestiona** tus tareas: edita, completa o elimina.
5. **Filtra** entre tareas pendientes y completadas.

---



## 📝 Mejoras Futuras

- [ ] Etiquetas/Categorías para tareas.
- [ ] Tareas recurrentes.
- [ ] Notificaciones por correo electrónico.
- [ ] API REST para integración con apps móviles.
- [ ] Compartir tareas entre usuarios.
- [ ] Modo oscuro.
- [ ] Exportar tareas a PDF/CSV.
- [ ] Recuperación de contraseña.

---

## 📄 Licencia

Este proyecto está bajo la licencia **MIT**. Siéntete libre de usarlo, modificarlo y distribuirlo.

---

## 👨‍💻 Autor

**Enderson**  
[![GitHub](https://img.shields.io/badge/GitHub-@endeR2104-181717?style=flat-square&logo=github)](https://github.com/endeR2104)  

---

## ⭐ ¿Te ha gustado?

Si este proyecto te ha sido útil, **¡no olvides darle una estrella ⭐ en GitHub!**  
Tu apoyo me ayuda a seguir creando contenido de calidad.

---

## 📧 Contacto

¿Tienes preguntas o sugerencias?  
📩 Escríbeme a: `ender20091124@gmail.com`

---

**¡Gracias por visitar el proyecto!** 🚀

---

## 📌 Notas Adicionales

- **Seguridad**: En entornos de producción, asegúrate de actualizar las contraseñas y configurar HTTPS.
- **Rendimiento**: La aplicación está optimizada para proyectos pequeños y medianos.
- **Compatibilidad**: Probado en Chrome, Firefox, Edge y Safari.

