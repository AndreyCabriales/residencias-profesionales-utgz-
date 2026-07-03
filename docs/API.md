# Documentación de Endpoints (API Interna y Proyectada)

El sistema actualmente opera bajo un enfoque Monolítico utilizando Web Routes (`routes/web.php`) con respuestas HTML/Redirects (Inertia/Blade). Sin embargo, la estructura está diseñada para evolucionar a una API REST JSON (`routes/api.php`) protegida mediante Laravel Sanctum.

A continuación se documentan los Endpoints críticos actuales (comportamiento Web) y su proyección como API REST.

---

## 1. Subir Documento (Alumno)

**Endpoint Actual (Web):** `POST /alumno/documentos`
**Endpoint Proyectado (API):** `POST /api/v1/alumnos/{alumno_id}/documentos`

### Propósito
Permite a un alumno subir un archivo en formato PDF correspondiente a su etapa activa. Si la etapa es `FOR-06-12`, también solicita y guarda los datos de la Empresa (`CompanyAdvisor`).

### Request Headers (Proyectado)
- `Authorization: Bearer {token}`
- `Accept: application/json`
- `Content-Type: multipart/form-data`

### Body (form-data)
| Clave | Tipo | Obligatorio | Descripción |
|-------|------|-------------|-------------|
| `documento` | file (PDF) | Sí | Archivo físico. Máximo 2MB. |
| `company_empresa` | string | Solo en FOR-06-12 | Nombre de la entidad receptora. |
| `company_nombre` | string | Solo en FOR-06-12 | Nombre del asesor organizacional. |
| `company_puesto` | string | Solo en FOR-06-12 | Puesto del asesor organizacional. |

### Ejemplo Request
```http
POST /api/v1/alumnos/1/documentos HTTP/1.1
Content-Type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW

------WebKitFormBoundary7MA4YWxkTrZu0gW
Content-Disposition: form-data; name="documento"; filename="carta_aceptacion.pdf"
Content-Type: application/pdf

(data)
------WebKitFormBoundary7MA4YWxkTrZu0gW
Content-Disposition: form-data; name="company_empresa"

TechCorp S.A. de C.V.
------WebKitFormBoundary7MA4YWxkTrZu0gW--
```

### Ejemplo Response (201 Created)
```json
{
  "success": true,
  "message": "Documento subido correctamente. En espera de revisión.",
  "data": {
    "id": 45,
    "estado": "Pendiente",
    "etapa_id": 1
  }
}
```

### Errores Posibles
- **422 Unprocessable Entity:** Validación fallida (El archivo no es PDF o supera el peso).
- **403 Forbidden:** El alumno intenta subir un documento pero ya tiene uno "Pendiente" en revisión.

---

## 2. Evaluar Documento (Asesor)

**Endpoint Actual (Web):** `PATCH /asesor/documentos/{id}/evaluar`
**Endpoint Proyectado (API):** `PATCH /api/v1/documentos/{id}/evaluar`

### Propósito
Permite al Asesor Académico dictaminar un documento como Aprobado o Rechazado.

### Request Headers
- `Authorization: Bearer {token}`
- `Accept: application/json`

### Body (JSON)
```json
{
  "estado": "aprobado", // o "rechazado"
  "comentarios": "Falta el sello de la empresa en la parte inferior." // (Futuro)
}
```

### Ejemplo Response (200 OK)
```json
{
  "success": true,
  "message": "Documento evaluado exitosamente."
}
```

### Comportamiento Interno (Webhooks/Events)
Al retornar un 200 OK de una "Aprobación", el sistema emite asíncronamente el evento `DocumentoRevisado`. El Alumno avanzará de etapa en el sistema sin que la API devuelva explícitamente esa información en este response.

### Errores Posibles
- **403 Forbidden:** El Asesor intenta aprobar un documento que pertenece a un Alumno que no le fue asignado.

---

## 3. Descargar Documento (Cualquier Rol)

**Endpoint Actual (Web):** `GET /documentos/{id}/descargar`
**Endpoint Proyectado (API):** `GET /api/v1/documentos/{id}/descargar`

### Propósito
Sirve el archivo físico del documento de forma segura. Dado que los archivos se guardan en el disco privado (`storage/app/documentos`), este endpoint aplica *Middleware* para asegurar que solo usuarios autorizados accedan al archivo.

### Response
Retorna un `BinaryStream` con `Content-Type: application/pdf`.
