# NoteFlow - Backend

Bienvenido al backend de **NoteFlow**, una aplicación colaborativa desarrollada en **Laravel 11**. Este sistema proporciona una gestión segura y eficiente de notas, documentos y espacios de trabajo, implementando **buenas prácticas de desarrollo** y un enfoque modular.

## 🚀 Características Principales

- **Autenticación basada en roles**: Uso de `firebase/php-jwt` para gestionar accesos y permisos.
- **Gestor de espacios de trabajo**: Permite la creación, edición y compartición de espacios.
- **Envió de correos electrónicos**: Integración con servicios de correo para notificaciones y confirmaciones.
- **Seguridad mejorada**: Implementación de claves privadas/públicas para JWT y almacenamiento seguro de credenciales.
- **Configuración flexible**: Uso de variables de entorno para facilitar despliegues.

---

## 📋 Requisitos Previos

Antes de comenzar, asegúrate de tener instalado lo siguiente:

- **PHP** >= 8.2
- **Composer**
- **MySQL** >= 5.7
- **Extensiones de PHP** necesarias: `openssl`, `pdo_mysql`
- **Dependencias del proyecto** (ya incluidas en `composer.json`):
  - `firebase/php-jwt`

---

## 📦 Instalación y Configuración

### 1 Clonar el repositorio
```bash
  git clone https://github.com/tu-usuario/noteflow-backend.git
  cd noteflow-backend
```

### 2 Instalar dependencias
Ejecuta el siguiente comando para instalar las dependencias del proyecto:
```bash
  composer install
```

### 3 Configurar el archivo `.env`
Copia el archivo de ejemplo y configúralo con los valores adecuados:
```bash
  cp .env.example .env
```
Edita el archivo `.env` y agrega la configuración de la base de datos y JWT:
```env
JWT_PRIVATE_KEY_PATH=storage/app/keys/privateKey.pem
JWT_PUBLIC_KEY_PATH=storage/app/keys/publicKey.pem

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_bd
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 4 Generar clave de aplicación
```bash
  php artisan key:generate
```
### 5 Generar clave openssl
```bash
  openssl ecparam -name prime256v1 -genkey -noout -out storage/app/keys/privateKey.pem
  openssl ec -in storage/app/keys/privateKey.pem -pubout -out storage/app/keys/publicKey.pem
```
### 6 Iniciar el servidor
```bash
  php artisan serve
```
Por defecto, la API estará disponible en `http://127.0.0.1:8000`

---

## 📚 Documentación de la API
Próximamente disponible con **Swagger**.

---

## 🛠️ Tecnologías Utilizadas
- **Laravel 11**
- **MySQL**
- **JWT Authentication** (`firebase/php-jwt`)
