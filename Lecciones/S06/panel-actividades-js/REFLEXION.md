## Reflexión - Reto 5: Consulta Pública con API

### 1. Datos que devuelve la API utilizada
Para este reto avanzado se consumió el endpoint público de `JSONPlaceholder` (`https://jsonplaceholder.typicode.com/posts/1`). Esta API devuelve un objeto estructurado en formato JSON con las siguientes propiedades:
- `userId`: Identificador único del usuario creador (Numérico).
- `id`: Identificador incremental del recurso técnico devuelto (Numérico).
- `title`: Una cadena de texto corta que funciona como título del concepto o entrada.
- `body`: Un bloque de texto más extenso con la descripción detallada del recurso.

### 2. Cómo se leyeron los datos desde JavaScript
La lectura se implementó a través de una función de flecha asíncrona (`const obtenerDatoTecnicoDelDia = async () => { ... }`). 
1. Se invocó la función global `fetch()` anteponiendo la palabra clave `await` para pausar la ejecución secuencial de esa función específica hasta obtener la respuesta de la red.
2. Se evaluó la propiedad `.ok` del objeto de respuesta para capturar anomalías del servidor (ej. errores 404 o 500) lanzando excepciones manuales con `throw new Error`.
3. Se transformó el flujo de bytes de la respuesta llamando al método asíncrono `.json()` mediante `await respuesta.json()`.
4. Una vez parseado el objeto nativo de JavaScript, se extrajeron las propiedades `.id`, `.title` y `.body` incrustándolas mediante Template Literals (`${}`) dentro de la interfaz gráfica usando manipulación estructurada del DOM (`innerHTML`). Todo el proceso fue envuelto dentro de un bloque estructurado `try/catch` para interceptar de forma segura caídas de internet sin afectar las demás operaciones locales del panel.