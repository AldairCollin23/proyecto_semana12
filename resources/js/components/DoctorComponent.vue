<template>
    <div class="container container-task">
        <div class="row">
            <div class="col-md-8">
                <h2>Doctores</h2>
                <table class="table text-center"><!--Creamos una tabla que mostrará todas las tareas-->
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">DNI</th>
                                <th scope="col">Especialidad</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="task in arrayTasks" :key="task.id"> <!--Recorremos el array y cargamos nuestra tabla-->
                                <td v-text="task.iddoctor"></td>
                                <td v-text="task.apellido"></td>
                                <td v-text="task.nombre"></td>
                                 <td v-text="task.dni"></td>
                                 <td v-text="task.especialidad"></td>
                                 

                                <td>
                                    <!--Botón modificar, que carga los datos del formulario con la tarea seleccionada-->
                                       <button class="btn btn-outline-info btn-sm" @click="loadFieldsUpdate(task)">Modificar</button>
                                    <!--Botón que borra la tarea que seleccionemos-->
                                    <button class="btn btn-outline-danger btn-sm" @click="deleteTask(task)">Borrar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            <div class="col-md-4">
                <div class="form-group"><!-- Formulario para la creación o modificación de nuestras tareas-->
                    <label>Apellido</label>
                    <input v-model="apellido" type="text" class="form-control">

                </div>

                 <div class="form-group"><!-- Formulario para la creación o modificación de nuestras tareas-->
                    <label>Nombre</label>
                    <input v-model="nombre" type="text" class="form-control">
                </div>

                <div class="form-group"><!-- Formulario para la creación o modificación de nuestras tareas-->
                    <label>DNI</label>
                    <input v-model="dni" type="text" class="form-control">
                </div>

                <div class="form-group"><!-- Formulario para la creación o modificación de nuestras tareas-->
                    <label>Especialidad</label>
                    <input v-model="especialidad" type="text" class="form-control">
                </div>

                <div class="container-buttons">
                    <!-- Botón que añade los datos del formulario, solo se muestra si la variable update es igual a 0-->
                    <button v-if="update == 0" @click="saveTasks()" class="btn btn-outline-success">Añadir</button>
                    <!-- Botón que modifica la tarea que anteriormente hemos seleccionado, solo se muestra si la variable update es diferente a 0-->
                    <button v-if="update != 0" @click="updateTasks()" class="btn btn-outline-warning">Actualizar</button>
                    <!-- Botón que limpia el formulario y inicializa la variable a 0, solo se muestra si la variable update es diferente a 0-->
                    <button v-if="update != 0" @click="clearFields()" class="btn btn-outline-danger">Atrás</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                apellido:"", //Esta variable, mediante v-model esta relacionada con el input del formulario
                nombre:"",
                dni:"",
                especialidad:"",
                update:0, /*Esta variable contrarolará cuando es una nueva tarea o una modificación, si es 0 significará que no hemos seleccionado
                          ninguna tarea, pero si es diferente de 0 entonces tendrá el id de la tarea y no mostrará el boton guardar sino el modificar*/
                arrayTasks:[], //Este array contendrá las tareas de nuestra bd
            }
        },
        methods:{
            getTasks(){
                let me =this;
                let url = '/doctor' //Ruta que hemos creado para que nos devuelva todas las doctor
                axios.get(url).then(function (response) {
                    //creamos un array y guardamos el contenido que nos devuelve el response
                    me.arrayTasks = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            saveTasks(){
                let me =this;
                let url = '/doctor/guardar' //Ruta que hemos creado para enviar una tarea y guardarla
                axios.post(url,{ //estas variables son las que enviaremos para que crear la tarea
                    'apellido':this.apellido,
                    'nombre':this.nombre,
                    'dni':this.dni,
                    'especialidad':this.especialidad,

                }).then(function (response) {
                    me.getTasks();//llamamos al metodo getTask(); para que refresque nuestro array y muestro los nuevos datos
                    me.clearFields();//Limpiamos los campos e inicializamos la variable update a 0
                })
                .catch(function (error) {
                    console.log(error);
                });   

            },
            updateTasks(){/*Esta funcion, es igual que la anterior, solo que tambien envia la variable update que contiene el id de la
                tarea que queremos modificar*/
                let me = this;
                axios.put('/doctor/actualizar',{
                    'iddoctor':this.update,
                    'apellido':this.apellido,
                    'nombre':this.nombre,
                    'dni':this.dni,
                    'especialidad':this.especialidad,

                }).then(function (response) {
                   me.getTasks();//llamamos al metodo getTask(); para que refresque nuestro array y muestro los nuevos datos
                   me.clearFields();//Limpiamos los campos e inicializamos la variable update a 0
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(data){ //Esta función rellena los campos y la variable update, con la tarea que queremos modificar
                this.update = data.iddoctor
                let me =this;
                let url = '/doctor/buscar?iddoctor='+this.update;
                axios.get(url).then(function (response) {
                    me.apellido= response.data.apellido;
                    me.nombre= response.data.nombre;
                    me.dni= response.data.dni;
                    me.especialidad= response.data.especialidad;

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                }); 
            },
            deleteTask(data){//Esta nos abrirá un alert de javascript y si aceptamos borrará la tarea que hemos elegiddoctoro
                let me =this;
                let task_id = data.iddoctor
                if (confirm('¿Seguro que deseas borrar esta tarea?')) {
                    axios.delete('/doctor/borrar/'+task_id
                    ).then(function (response) {
                        me.getTasks();
                    })
                    .catch(function (error) {
                        console.log(error);
                    }); 
                }
            },
            clearFields(){/*Limpia los campos e inicializa la variable update a 0*/
                this.apellido = "";
                this.nombre = "";
                this.dni = "";
                this.especialidad = "";

                this.update = 0;
            }
        },
        mounted() {
           this.getTasks();
        }
    }
</script>

