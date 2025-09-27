| Método HTTP | Ruta                    | Acción en el controlador | Propósito                     |
| ----------- | ----------------------- | ------------------------ | ----------------------------- |
| GET         | /users                  | `index()`                | Listar todos los recursos     |
| GET         | /users/new              | `new()`                  | Formulario para crear uno     |
| POST        | /users                  | `create()`               | Guardar un nuevo recurso      |
| GET         | /users/(\:segment)      | `show($id)`              | Mostrar un recurso específico |
| GET         | /users/(\:segment)/edit | `edit($id)`              | Formulario para editar        |
| PUT/PATCH   | /users/(\:segment)      | `update($id)`            | Actualizar un recurso         |
| DELETE      | /users/(\:segment)      | `delete($id)`            | Eliminar un recurso           |
